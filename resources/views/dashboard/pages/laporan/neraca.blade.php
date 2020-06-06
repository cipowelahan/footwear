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
            <div class="row">
                <div class="col-sm-6">
                    <table class="table table-bordered" style="width:100%">
                        <tbody>
                            <tr>
                                <th colspan="2" style="text-align: center">AKTIVA</th>
                            </tr>
                            <tr>
                                <th style="width: 40%">Kas</th>
                                <td id="kas">{{number_format($neraca['kas'])}}</td>
                            </tr>
                            {{-- <tr>
                                <th>Pembelian</th>
                                <td id="pembelian">0</td>
                            </tr> --}}
                            <tr>
                                <th>Persediaan</th>
                                <td id="persediaan">{{number_format($neraca['persediaan'])}}</td>
                            </tr>
                            <tr>
                                <th>Asset</th>
                                <td id="asset">{{number_format($neraca['asset'])}}</td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <th id="aktiva">{{number_format($neraca['aktiva'])}}</th>
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
                                <td id="modal">{{number_format($neraca['modal'])}}</td>
                            </tr>
                            <tr>
                                <th>Laba Ditahan</th>
                                <td id="laba_rugi_akhir">{{number_format($neraca['laba_rugi_akhir'])}}</td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <th id="pasiva">{{number_format($neraca['pasiva'])}}</th>
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

    $('[name=tanggal]').select2();

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

        $('#cetak').click(function() {
            var tanggal = $('[name=tanggal]').val()
            window.open(`${thisPath}/${tanggal}`)
        })
    })

</script>