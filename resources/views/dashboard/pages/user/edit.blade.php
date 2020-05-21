<section class="content-header">
    <h1>
        Edit Data User
        <small>Edit Data User</small>
    </h1>
</section>

<section class="content">
    <div class="box">

        <form class="form-horizontal" method="POST">
            <div class="box-body">
                {{csrf_field()}}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="status_martial">ID</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="text" name="id" value="{{$user->id}}" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="nama">Nama</label>
                    <div class="col-sm-5">
                        <input type="text" name="nama" placeholder="Nama" class="form-control" value="{{$user->nama}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="email">Username</label>
                    <div class="col-sm-5">
                        <input type="text" name="username" placeholder="Username" class="form-control" value="{{$user->username}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="email">Password</label>
                    <div class="col-sm-5">
                        <input type="password" name="password" placeholder="Password" class="form-control">
                        <p class="help-block">* Kosongkan Jika tidak ingin mengubah Password</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="nama_perusahaan">No HP</label>
                    <div class="col-sm-5">
                        <input type="text" name="no_hp" placeholder="No HP" class="form-control" value="{{$user->no_hp}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="kontak">Alamat</label>
                    <div class="col-sm-5">
                        <textarea name="alamat" class="form-control" placeholder="Alamat">{{$user->alamat}}</textarea>
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
        routeMenu('get', thisPath.replace("/edit", ""));
    }

    $(function() {

        $('form').submit(function(e) {
            e.preventDefault();
            var data = $(this).serialize();
            bootbox.confirm('Anda yakin ?', function(ok) {
                if (ok) {
                    routeMenu('post', thisPath, data, function(result) {
                        if (result == "1") {
                            routeMenu('get', thisPath.replace("/edit", ""));
                            notification('berhasil', 'success');
                        }
                    });

                }
            })
        })
        
    })

</script>