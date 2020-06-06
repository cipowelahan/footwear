<section class="content-header">
    <h1>
        Laporan Perubahan Ekuitas
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
                        <th style="width: 40%">Laba Ditahan Awal</th>
                        <td id="laba_rugi_lalu">0</td>
                    </tr>
                    <tr>
                        <th>Laba Ditahan Periode</th>
                        <td id="laba_rugi_sekarang">0</td>
                    </tr>
                    <tr>
                        <th>Laba Yang Tersedia</th>
                        <td id="laba_rugi_tersedia">0</td>
                    </tr>
                    <tr>
                        <th>Prive</th>
                        <td>(<span id="prive">0</span>)</td>
                    </tr>
                    <tr>
                        <th>Laba Ditahan Akhir</th>
                        <td id="laba_rugi_akhir">0</td>
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

    function getPerubahanEkuitas(tanggal) {
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
            getPerubahanEkuitas($(this).val())
        })

        $('#cetak').click(function() {
            var tanggal = $('[name=tanggal]').val()
            window.open(`${thisPath}/${tanggal}`)
        })
    })

</script>