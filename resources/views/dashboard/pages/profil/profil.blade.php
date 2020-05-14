<section class="content-header">
    <h1>
        Edit Profil
    </h1>
</section>

<section class="content">
    <form class="form-horizontal" action="post" enctype="multipart/form-data">
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
                    <label class="col-sm-2 control-label" for="username">Username</label>
                    <div class="col-sm-5">
                        <input type="text" name="username" placeholder="Username" class="form-control" value="{{$user->username}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="no_hp">No HP</label>
                    <div class="col-sm-5">
                        <input type="text" name="no_hp" placeholder="No HP" class="form-control" value="{{$user->no_hp}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="alamat">Alamat</label>
                    <div class="col-sm-5">
                        <textarea name="alamat" class="form-control" rows="4" placeholder="Alamat">{{$user->alamat}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="foto">Foto</label>
                    <div class="col-sm-5">
                        @if($user->foto)
                        <div id="gambar">
                            <img src="{{asset('public/'.$user->foto)}}" class="img-thumbnail">
                            <br>
                            <br>
                            <button type="button" class="btn btn-warning" onclick="changeImage()">Ganti Gambar</button>
                        </div>
                        @endif
                        <div id="input-gambar" @if($user->foto) style="display: none" @endif>
                            <input name="foto" class="form-control" type="file" accept="image/*">
                        </div>
                        @if($user->foto)
                        <div style="display: none" id="btn-cancel-gambar">
                            <br>
                            <button type="button" class="btn btn-danger" onclick="cancelChangeImage()">Batalkan Ganti Gambar</button>
                        </div>
                        @endif
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

    $('[type=file]').fileinput({
        showUpload: false,
        dropZoneEnabled: false,
        autoOrientImage: false,
        allowedFileExtensions: ['jpeg', 'jpg', 'png']
    })

    function changeImage() {
        $('#gambar').hide()
        $('#input-gambar').show()
        $('#btn-cancel-gambar').show()
    }

    function cancelChangeImage() {
        $('#gambar').show()
        $('#input-gambar').hide()
        $('#btn-cancel-gambar').hide()
        $('[type=file]').fileinput('clear')
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
                            if (result.success) {
                                routeMenu('get', thisPath);
                                $('#profil-head').text(result.data.nama)
                                $('#profil-nama').text(result.data.nama)
                                $('#profil-username').text(result.data.username)
                                $('#profil-foto-head').attr('src', '{{url('public')}}/'+result.data.foto)
                                $('#profil-foto').attr('src', '{{url('public')}}/'+result.data.foto)
                                notification('berhasil', 'success');
                            }
                            else {
                                notification(result.message, 'error');
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
    })
</script>