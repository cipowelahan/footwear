<section class="content-header">
    <h1>
        Tambah Data Karyawan
        <small>Tambah Data Karyawan</small>
    </h1>
</section>

<section class="content">
    <div class="box">

        <form class="form-horizontal" method="POST">
            <div class="box-body">
                {{csrf_field()}}
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="nama">Nama</label>
                    <div class="col-sm-5">
                        <input name="nama" class="form-control" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="jabatan">Jabatan</label>
                    <div class="col-sm-5">
                        <input name="jabatan" class="form-control" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="posisi">Posisi</label>
                    <div class="col-sm-5">
                        <input name="posisi" class="form-control" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="alamat">Alamat</label>
                    <div class="col-sm-5">
                        <textarea name="alamat" class="form-control"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="kontak">Kontak</label>
                    <div class="col-sm-5">
                        <input name="kontak" class="form-control" type="text">
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

    function cancel() {
        event.preventDefault();
        routeMenu('get', thisPath.replace("/create", ""));
    }

    $(function() {

        $('form').submit(function(e) {
            e.preventDefault();
            var data = $(this).serialize();
            bootbox.confirm('Anda yakin ?', function(ok) {
                if (ok) {
                    routeMenu('post', thisPath, data, function(result) {
                        if (result == "1") {
                            routeMenu('get', thisPath.replace("/create", ""));
                            notification('berhasil', 'success');
                        }
                    });

                }
            })
        })
        
    })

</script>