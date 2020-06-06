<style>
    .select2 {
        width: 100%!important;
    }
    
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #000000;
    }
</style>

<section class="content-header">
    <h1>
        Detail Transaksi
    </h1>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <button id="back" type="button" class="btn btn-warning" href="{{$lastUrl}}">Kembali</button>
            <button id="riwayat" type="button" class="btn btn-primary">Riwayat Transaksi</button>
        </div>

        <div class="box-body">
            <form>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label" for="tanggal">ID</label>
                            <input class="form-control" type="text" value="{{$transaksi->id}}" readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="tanggal">Jenis</label>
                            <input class="form-control" type="text" value="{{ucfirst($transaksi->jenis)}}" readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="tanggal">Tanggal</label>
                            <input class="form-control" type="text" value="{{$transaksi->tanggal}}" readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="supplier_id">Supplier</label>
                            <input class="form-control" type="text" value="{{@$transaksi->supplier->nama}}" readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="total">Diskon</label>
                            <input class="form-control" type="text" value="{{$transaksi->diskon_format}}" readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="total">Total</label>
                            <input class="form-control" type="text" value="{{$transaksi->total_format}}" readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="total">Total HPP</label>
                            <input class="form-control" type="text" value="{{$transaksi->total_hpp_format}}" readonly>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="table-responsive">
                            <table class="table table-bordered" style="width:100%">
                                <thead>
                                    <tr style="background-color: #3c8dbc; color: #ffffff">
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Harga</th>
                                        <th style="width: 10%">Jumlah</th>
                                        <th>Total</th>
                                        <th>HPP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transaksi->tr_produk as $produk)
                                    <tr>
                                        <td>{{$produk->kode_produk}}</td>
                                        <td>{{$produk->nama_produk}}</td>
                                        <td>{{$produk->harga_format}}</td>
                                        <td>{{$produk->jumlah}}</td>
                                        <td>{{$produk->total_format}}</td>
                                        <td>{{$produk->hpp_format}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
</section>

<script>
    var thisPath = "{{request()->url()}}";

    $(function() {
        $('#riwayat').click(function(e) {
            e.preventDefault()
            routeMenu('get', thisPath.replace('/detail', ''))
        })

        $('#back').click(function(e) {
            e.preventDefault()
            routeMenu('get', $(this).attr('href'))
        })
    })
</script>