<section class="content-header">
    <h1>
        Laporan Penjualan
    </h1>
</section>

<section class="content">
    <div class="box">

        <div class="box-body">
            <div class="row">
                <div class="col-sm-2">
                    Pilih Bulan
                </div>
                <div class="col-sm-3">
                    <select name="tanggal" class="form-control">
                        @foreach($tanggal as $t)
                        <option value="{{$t['tahun_bulan']}}">{{$t['tahun_bulan_format']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-2">
                    <button id="cetak" type="butotn" class="btn btn-primary"><i class="fa fa-print"></i> Cetak</button>
                </div>
            </div>
            <hr>
            <div id="canvas-chart">
                <canvas id="chart-penjualan" width="100%" height="25"></canvas>
            </div>
            <hr>
            <table class="table table-bordered" style="width:100%">
                <thead>
                    <tr style="background-color: #3c8dbc; color: #ffffff">
                        <th style="width: 20%">Kode</th>
                        <th>Nama</th>
                        <th style="width: 10%; text-align: right">Jumlah</th>
                        <th style="text-align: right">Total Harga</th>
                    </tr>
                </thead>
                <tbody id="persediaan">
                    @foreach($produk as $data)
                    <tr>
                        <td>{{$data->kode_produk}}</td>
                        <td>{{$data->nama_produk}}</td>
                        <td style="text-align: right">{{$data->sum_jumlah}}</td>
                        <td style="text-align: right">{{number_format($data->sum_total)}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background-color: #3c8dbc; color: #ffffff">
                        <th colspan="2" style="text-align: right">TOTAL SEMUA</th>
                        <th id="total-jumlah" style="text-align: right">{{$jumlah}}</th>
                        <th id="total-harga" style="text-align: right">{{number_format($harga)}}</th>
                    </tr>
                </tfoot>
            </table>
            
        </div>
    </div>
</section>

<script>
    var thisPath = "{{request()->url()}}";

    $('[name=tanggal]').select2();

    function toCurrency(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }

    function generateChart(chart) {
        $('#canvas-chart').empty()
        $('#canvas-chart').append(`<canvas id="chart-penjualan" width="100%" height="25"></canvas>`)

        var ctx = $('#chart-penjualan')

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chart.labels,
                datasets: [
                    {
                        label: 'Laporan Penjualan',
                        data: chart.datas,
                        backgroundColor: chart.colors,
                        borderColor: chart.colors
                    }
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        })
    }

    function getPenjualan(tanggal) {
        loader('show')
        $.ajax({
            method: 'post',
            url: thisPath,
            data: { 
                tanggal,
                _token: "{{csrf_token()}}"
            },
            success: function(result) {
                $('#persediaan').empty()
                result.produk.forEach(el => {
                    var template = `
                        <tr>
                            <td>${el.kode_produk}</td>
                            <td>${el.nama_produk}</td>
                            <td style="text-align: right">${el.sum_jumlah}</td>
                            <td style="text-align: right">${toCurrency(el.sum_total)}</td>
                        </tr>
                    `

                    $('#persediaan').append(template)
                })

                $('#total-jumlah').text(result.jumlah)
                $('#total-harga').text(toCurrency(result.harga))
                generateChart(result.chart)
                loader('hide')
            }
        })
    }

    $(function() {
        getPenjualan($('[name=tanggal]').val())

        $('[name=tanggal]').change(function(e) {
            e.preventDefault()
            getPenjualan($(this).val())
        })

        $('#cetak').click(function() {
            var tanggal = $('[name=tanggal]').val()
            window.open(`${thisPath}/${tanggal}`)
        })
    })

</script>