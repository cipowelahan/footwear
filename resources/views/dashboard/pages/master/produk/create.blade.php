<style>
    .select2 {
        width:100%!important;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #000000;
    }
</style>

<section class="content-header">
    <h1>
        Tambah Data Produk
        <small>Tambah Data Produk</small>
    </h1>
</section>

<section class="content">
    <div class="box">

        <form class="form-horizontal" method="POST" enctype="multipart/form-data">
            <div class="box-body">
                {{csrf_field()}}
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="foto">Foto</label>
                    <div class="col-sm-5">
                        <input name="foto" class="form-control" type="file" accept="image/*">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="kode">Kode</label>
                    <div class="col-sm-5">
                        <input name="kode" class="form-control" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="nama">Nama</label>
                    <div class="col-sm-5">
                        <input name="nama" class="form-control" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="kategori_id">Kategori</label>
                    <div class="col-sm-5">
                        <select name="kategori_id" id="kategori" class="form-control">
                            @foreach($kategori as $k)
                            <option value="{{$k->id}}">{{$k->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="merk">Merk</label>
                    <div class="col-sm-5">
                        <input name="merk" class="form-control" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="warna">Warna</label>
                    <div class="col-sm-5">
                        <input name="warna" class="form-control" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="ukuran">Ukuran</label>
                    <div class="col-sm-5">
                        <input name="ukuran" class="form-control" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="stok">Stok</label>
                    <div class="col-sm-5">
                        <input name="stok" class="form-control number-input" type="text" value="0" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="harga_beli">Harga Beli</label>
                    <div class="col-sm-5">
                        <input name="harga_beli" class="form-control currency-input" type="text" value="0">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="harga_beli">Harga Jual</label>
                    <div class="col-sm-5">
                        <input name="harga_jual" class="form-control currency-input" type="text" value="0">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="deskripsi">Deskripsi</label>
                    <div class="col-sm-5">
                        <textarea name="deskripsi" class="form-control" placeholder="Deskripsi" rows="4"></textarea>
                    </div>
                </div>
            </div>
    
            <div class="box-footer">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for=""></label>
                    <div class="col-sm-5">
                        <button class="btn btn-warning" type="button" onclick="cancel()">Batalkan</button>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    var thisPath = "{{request()->url()}}";

    $('select').select2()

    $('[type=file]').fileinput({
        showUpload: false,
        dropZoneEnabled: false,
        autoOrientImage: false,
        allowedFileExtensions: ['jpeg', 'jpg', 'png']
    })

    function cancel() {
        event.preventDefault();
        routeMenu('get', thisPath.replace("/create", ""));
    }

    $(function() {

        $('form').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            bootbox.confirm('Anda yakin ?', function(ok) {
                if (ok) {
                    loader('show')
                    $.ajax({
                        url : thisPath,
                        method : 'POST',
                        data : formData,
                        cache: false,                                                
                        contentType: false,                                             
                        processData: false,
                        success: function(result) {
                            loader('hide')
                            if (result == "1") {
                                routeMenu('get', thisPath.replace("/create", ""));
                                notification('berhasil', 'success');
                            }
                            else {
                                notification(result, 'error');
                            }
                        },
                        error: function(error) {
                            loader('hide')
                            if (error.status == 422) notification(error.responseText, 'error');
                            else notification(error.statusText, 'error');
                        }
                    });

                }
            })
        })

        $('.number-input').keyup(function(event) {
            var selection = window.getSelection().toString();
            if (selection !== '') {
                return
            }

            if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
                return
            }

            var $this = $(this)
            var input = $this.val()

            input = input.replace(/[\D\s\._\-]+/g, "")
            input = input ? parseInt( input, 10 ) : 0

            $this.val(function() {
                return (input === 0) ? "0" : input
            })
        })

        $('.currency-input').keyup(function(event) {
            var selection = window.getSelection().toString();
            if (selection !== '') {
                return
            }

            if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
                return
            }

            var $this = $(this)
            var input = $this.val()

            input = input.replace(/[\D\s\._\-]+/g, "")
            input = input ? parseInt( input, 10 ) : 0

            $this.val(function() {
                return (input === 0) ? "0" : input.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
            })
        })
        
    })

</script>