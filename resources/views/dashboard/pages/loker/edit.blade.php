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
        Edit Data Loker
        <small>Edit Data Loker</small>
    </h1>
</section>

<section class="content">
    <div class="box">

        <form class="form-horizontal" method="POST" enctype="multipart/form-data">
            <div class="box-body">
                {{csrf_field()}}
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="status_martial">ID</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="text" name="id" value="{{$loker->id}}" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="nama">Judul</label>
                    <div class="col-sm-5">
                        <input name="judul" class="form-control" type="text" value="{{$loker->judul}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="kota">Kota</label>
                    <div class="col-sm-5">
                        <select name="kota" class="form-control">
                            @foreach($kota as $k)
                            <option 
                                value="{{$k}}"
                                @if($loker->kota == $k) selected @endif
                            >{{$k}}</option>
                            @endforeach
                        </select>
                        <p class="help-block">* Jika kota yang dicari tidak ada, silahkan isi manual</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="jenis">Jenis</label>
                    <div class="col-sm-5">
                        <select name="jenis[]" class="form-control" multiple="multiple">
                            @foreach($jenis as $j)
                            <option 
                                value="{{$j}}"
                                @if(in_array($j, $loker->jenis_list)) selected @endif
                            >{{$j}}</option>
                            @endforeach
                        </select>
                        <p class="help-block">* Jika jenis yang dicari tidak ada, silahkan isi manual</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="gambar">Gambar</label>
                    <div class="col-sm-5">
                        @if($loker->gambar)
                        <div id="gambar">
                            <img src="{{asset($loker->gambar)}}" class="img-thumbnail">
                            <br>
                            <br>
                            <button type="button" class="btn btn-warning" onclick="changeImage()">Ganti Gambar</button>
                        </div>
                        @endif
                        <div id="input-gambar" @if($loker->gambar) style="display: none" @endif>
                            <input name="gambar" class="form-control" type="file" accept="image/*">
                        </div>
                        @if($loker->gambar)
                        <div style="display: none" id="btn-cancel-gambar">
                            <br>
                            <button type="button" class="btn btn-danger" onclick="cancelChangeImage()">Batalkan Ganti Gambar</button>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="deskripsi">Deskripsi</label>
                    <div class="col-sm-8">
                        <textarea name="deskripsi" class="form-control">{{$loker->deskripsi}}</textarea>
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

    $('select').select2({
        tags: true,
    })

    $('textarea').summernote({
        height: 400,
        placeholder: 'Deskripsi Loker',
    })

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

    function cancel() {
        event.preventDefault();
        routeMenu('get', thisPath.replace("/edit", ""));
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
                                routeMenu('get', thisPath.replace("/edit", ""));
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
        
    })

</script>