<section class="content-header">
    <h1>
        Edit Profil
    </h1>
</section>

<section class="content">
    <form class="form-horizontal" action="">
        <div class="box">
            <div class="box-body">
                {{csrf_field()}}
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
                        if (result.success) {
                            routeMenu('get', thisPath);
                            $('#profil-head').text(result.data.nama)
                            $('#profil-nama').text(result.data.nama)
                            $('#profil-email').text(result.data.email)
                            $('#profil-nama-perusahaan').text(result.data.nama_perusahaan)
                            $('#profil-kontak').text(result.data.kontak)
                            notification('berhasil', 'success');
                        }
                    });

                }
            })
        })
    })
</script>