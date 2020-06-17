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
                        <th rowspan="2" style="text-align: center; vertical-align: middle;">Kode Produk</th>
                        <th colspan="6" style="text-align: center;">Nama Produk</th>
                    </tr>
                    <tr style="background-color: #3c8dbc; color: #ffffff">
                        <th style="text-align: center">ID</th>
                        <th style="text-align: center">Tanggal</th>
                        <th style="text-align: center">User</th>
                        <th style="text-align: right">Harga</th>
                        <th style="text-align: right">Jumlah</th>
                        <th style="text-align: right">Total Harga</th>
                    </tr>
                </thead>
                <tbody id="persediaan">
                    @foreach($produk as $data)
                    <tr>
                        <th style="text-align: center; width: 15%;">{{$data->kode_produk}}</th>
                        <th colspan="6" style="text-align: center">{{$data->nama_produk}}</th>
                    </tr>
                    @foreach($data->list_transaksi as $transaksi)
                    <tr>
                        <td></td>
                        <td style="text-align: center; width: 5%;">{{$transaksi->id}}</td>
                        <td style="text-align: center; width: 10%;">{{$transaksi->tanggal}}</td>
                        <td style="text-align: center; width: 15%;">{{$transaksi->user}}</td>
                        <td style="text-align: right">{{$transaksi->harga}}</td>
                        <td style="text-align: right">{{$transaksi->jumlah}}</td>
                        <td style="text-align: right">{{$transaksi->total_format}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <th colspan="5" style="text-align: right">TOTAL</th>
                        <th style="text-align: right">{{$data->sum_jumlah}}</th>
                        <th style="text-align: right">{{$data->sum_total_format}}</th>
                    </tr>
                    <tr>
                        <td colspan="7" style="background-color: gray"></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background-color: #3c8dbc; color: #ffffff">
                        <th colspan="5" style="text-align: right">TOTAL SEMUA</th>
                        <th id="total-jumlah" style="text-align: right">{{$jumlah}}</th>
                        <th id="total-harga" style="text-align: right">{{number_format($harga)}}</th>
                    </tr>
                    <tr style="background-color: #3c8dbc; color: #ffffff">
                        <th colspan="6" style="text-align: right">TOTAL DISKON TRANSAKSI</th>
                        <th id="total-diskon" style="text-align: right">({{number_format($diskon)}})</th>
                    </tr>
                    <tr style="background-color: #3c8dbc; color: #ffffff">
                        <th colspan="6" style="text-align: right">TOTAL PENJUALAN</th>
                        <th id="total-penjualan" style="text-align: right">{{number_format($harga - $diskon)}}</th>
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
                            <td style="text-align: center; width: 15%;">${el.kode_produk}</td>
                            <td colspan="6" style="text-align: center">${el.nama_produk}</td>
                        </tr>
                    `

                    for (let index = 0; index < el.list_transaksi.length; index++) {
                        const transaksi = el.list_transaksi[index];
                        template += `
                            <tr>
                                <td></td>
                                <td style="text-align: center; width: 5%;">${transaksi.id}</td>
                                <td style="text-align: center; width: 10%;">${transaksi.tanggal}</td>
                                <td style="text-align: center; width: 15%;">${transaksi.user}</td>
                                <td style="text-align: right">${transaksi.harga}</td>
                                <td style="text-align: right">${transaksi.jumlah}</td>
                                <td style="text-align: right">${transaksi.total_format}</td>
                            </tr>
                        `
                    }

                    template += `
                        <tr>
                            <th colspan="5" style="text-align: right">TOTAL</th>
                            <th style="text-align: right">${el.sum_jumlah}</th>
                            <th style="text-align: right">${el.sum_total_format}</th>
                        </tr>
                        <tr>
                            <td colspan="7" style="background-color: gray"></td>
                        </tr>
                    `

                    $('#persediaan').append(template)
                })

                $('#total-jumlah').text(result.jumlah)
                $('#total-harga').text(toCurrency(result.harga))
                $('#total-diskon').text(`(${toCurrency(result.diskon)})`)
                $('#total-penjualan').text(toCurrency(result.harga - result.diskon))
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