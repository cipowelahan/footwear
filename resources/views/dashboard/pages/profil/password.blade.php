<section class="content-header">
    <h1>
        Ubah Kata Sandi
    </h1>
</section>

<section class="content">
    <form class="form-horizontal" method="POST">
        <div class="box">
            <div class="box-body">
                {{csrf_field()}}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="old_password">Kata Sandi Lama</label>
                    <div class="col-sm-5">
                        <input type="password" name="old_password" placeholder="Kata Sandi Lama" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="password">Kata Sandi Baru</label>
                    <div class="col-sm-5">
                        <input type="password" name="password" placeholder="Kata Sandi Baru" class="form-control">
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for=""></label>
                    <div class="col-sm-5">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>

<script>
    var thisPath = "{{request()->url()}}";

    $(function() {
        $('form').submit(function(e) {
            e.preventDefault();
            let data = $(this).serialize();
            
            bootbox.confirm('Anda yakin ?', function(ok) {
                if (ok) {
                    routeMenu('post', thisPath, data, function(result) {
                        if (result == "1") {
                            routeMenu('get', thisPath);
                            notification('berhasil', 'success');
                        }
                        else {
                            loader('hide');
                            notification(result, 'error');
                        }
                    });

                }
            })
        })
    })
</script>