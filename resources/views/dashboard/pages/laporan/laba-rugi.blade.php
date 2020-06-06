<section class="content-header">
    <h1>
        Laporan Laba Rugi
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
                        <option value="">Pilih Tanggal</option>
                        @foreach($tanggal as $t)
                        <option value="{{$t['tahun_bulan']}}">{{$t['tahun_bulan_format']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-2">
                    <button id="cetak" type="butotn" class="btn btn-primary" disabled><i class="fa fa-print"></i> Cetak</button>
                </div>
            </div>
            <hr>
            <table class="table table-bordered" style="width:100%">
                <tbody>
                    <tr>
                        <th style="width: 40%">Penjualan</th>
                        <td id="penjualan">0</td>
                    </tr>
                    <tr>
                        <th>Potongan Penjualan</th>
                        <td>(<span id="potongan_penjualan">0</span>)</td>
                    </tr>
                    <tr>
                        <th>Penjualan Bersih</th>
                        <td id="penjualan_bersih">0</td>
                    </tr>
                    <tr>
                        <th>HPP</th>
                        <td>(<span id="hpp">0</span>)</td>
                    </tr>
                    <tr>
                        <th>Laba Kotor</th>
                        <td id="laba_kotor">0</td>
                    </tr>
                    <tr>
                        <th>Beban Utilitas</th>
                        <td>(<span id="beban_utilitas">0</span>)</td>
                    </tr>
                    <tr>
                        <th>Beban Iklan</th>
                        <td>(<span id="beban_iklan">0</span>)</td>
                    </tr>
                    <tr>
                        <th>Beban Sewa</th>
                        <td>(<span id="beban_sewa">0</span>)</td>
                    </tr>
                    <tr>
                        <th>Beban Pemeliharaan dan Perbaikan</th>
                        <td>(<span id="beban_pemeliharaan">0</span>)</td>
                    </tr>
                    <tr>
                        <th>Beban Gaji</th>
                        <td>(<span id="beban_gaji">0</span>)</td>
                    </tr>
                    <tr>
                        <th>Beban Perlengkapan</th>
                        <td>(<span id="beban_perlengkapan">0</span>)</td>
                    </tr>
                    <tr>
                        <th>Laba Bersih</th>
                        <td id="laba_bersih">0</td>
                    </tr>
                </tbody>
            </table>
            
        </div>
    </div>
</section>

<script>
    var thisPath = "{{request()->url()}}";

    $('[name=tanggal]').select2({
        placeholder: 'Pilih Tanggal'
    });

    function toCurrency(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }

    function getLabaRugi(tanggal) {
        loader('show')
        $.ajax({
            method: 'post',
            url: thisPath,
            data: { 
                tanggal,
                _token: "{{csrf_token()}}"
            },
            success: function(result) {
                for (var data in result) {
                    if (result.hasOwnProperty(data)) {
                        $(`#${data}`).text(toCurrency(result[data]))
                    }
                }
                loader('hide')
            }
        })
    }

    $(function() {
        $('[name=tanggal]').change(function(e) {
            $('#cetak').prop('disabled', false)
            e.preventDefault()
            getLabaRugi($(this).val())
        })

        $('#cetak').click(function() {
            var tanggal = $('[name=tanggal]').val()
            window.open(`${thisPath}/${tanggal}`)
        })
    })

</script>