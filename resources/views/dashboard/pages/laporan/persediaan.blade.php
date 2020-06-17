<section class="content-header">
    <h1>
        Laporan Persediaan
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
            <table class="table table-bordered" style="width:100%">
                <thead>
                    <tr style="background-color: #3c8dbc; color: #ffffff">
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Merk</th>
                        <th>Stok</th>
                        <th>Harga Beli</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody id="persediaan">
                    @foreach($produk as $data)
                    <tr>
                        <td>{{$data->kode}}</td>
                        <td>{{$data->nama}}</td>
                        <td>{{@$data->kategori->nama}}</td>
                        <td>{{$data->merk}}</td>
                        <td>{{$data->stok}}</td>
                        <td>{{$data->harga_beli_format}}</td>
                        <td>{{$data->total}}</td>
                    </tr>
                    @endforeach
                </tbody>
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

    function getPersediaan(tanggal) {
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
                result.forEach(el => {
                    var template = `
                        <tr>
                            <td>${el.kode}</td>
                            <td>${el.nama}</td>
                            <td>${(el.kategori)?el.kategori.nama:''}</td>
                            <td>${el.merk}</td>
                            <td>${el.stok}</td>
                            <td>${el.harga_beli_format}</td>
                            <td>${el.total}</td>
                        </tr>
                    `

                    $('#persediaan').append(template)
                })
                loader('hide')
            }
        })
    }

    $(function() {
        $('[name=tanggal]').change(function(e) {
            e.preventDefault()
            getPersediaan($(this).val())
        })

        $('#cetak').click(function() {
            var tanggal = $('[name=tanggal]').val()
            window.open(`${thisPath}/${tanggal}`)
        })
    })

</script>