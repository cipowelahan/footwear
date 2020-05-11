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
                    <label class="col-sm-2 control-label" for="kelamin">Kelamin</label>
                    <div class="col-sm-5">
                        <select name="kelamin" class="form-control">
                            <option value="L" @if($user->kelamin == 'L') selected @endif >Laki - Laki</option>
                            <option value="P" @if($user->kelamin == 'P') selected @endif >Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="email">Email</label>
                    <div class="col-sm-5">
                        <input type="email" name="email" placeholder="Email" class="form-control" value="{{$user->email}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="email">Password</label>
                    <div class="col-sm-5">
                        <input type="password" name="password" placeholder="Password" class="form-control">
                        <p class="help-block">* Kosongkan jika tidak ingin mengubah kata sandi.</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="nama_perusahaan">Nama Perusahaan</label>
                    <div class="col-sm-5">
                        <input type="text" name="nama_perusahaan" placeholder="Nama Perusahaan" class="form-control" value="{{$user->nama_perusahaan}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="kontak">Kontak</label>
                    <div class="col-sm-5">
                        <input type="text" name="kontak" placeholder="Kontak" class="form-control" value="{{$user->kontak}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="role_id">Role</label>
                    <div class="col-sm-5">
                        <select name="role_id" class="form-control">
                            @foreach($role as $r)
                            <option value="{{$r->id}}" @if($user->role_id == $r->id) selected @endif >{{$r->nama}}</option>
                            @endforeach
                        </select>
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