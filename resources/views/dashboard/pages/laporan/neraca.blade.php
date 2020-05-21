<section class="content-header">
    <h1>
        Laporan Neraca
    </h1>
</section>

<section class="content">
    <div class="box">

        <div class="box-body">
            <div class="row">
                <div class="col-sm-2">
                    Pilih Bulan
                </div>
                <div class="col-sm-4">
                    <select name="tanggal" class="form-control">
                        <option value="">Pilih Tanggal</option>
                        @foreach($tanggal as $t)
                        <option value="{{$t['tahun_bulan']}}">{{$t['tahun_bulan_format']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-6">
                    <table class="table table-bordered" style="width:100%">
                        <tbody>
                            <tr>
                                <th colspan="2" style="text-align: center">AKTIVA</th>
                            </tr>
                            <tr>
                                <th style="width: 40%">Kas</th>
                                <td id="kas">0</td>
                            </tr>
                            <tr>
                                <th>Pembelian</th>
                                <td id="pembelian">0</td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td id="aktiva">0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-6">
                    <table class="table table-bordered" style="width:100%">
                        <tbody>
                            <tr>
                                <th colspan="2" style="text-align: center">PASIVA</th>
                            </tr>
                            <tr>
                                <th style="width: 40%">Modal</th>
                                <td id="modal">0</td>
                            </tr>
                            <tr>
                                <th>Laba Ditahan</th>
                                <td id="laba_rugi_akhir">0</td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td id="pasiva">0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
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

    function getNeraca(tanggal) {
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
            e.preventDefault()
            getNeraca($(this).val())
        })
    })

</script>