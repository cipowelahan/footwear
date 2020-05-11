<section class="content-header">
    <h1>
        Tambah Data Pencari Kerja
        <small>Tambah Data Pencari Kerja</small>
    </h1>
</section>

<section class="content">
    <div class="box">

        <form class="form-horizontal" method="POST" enctype="multipart/form-data">
            <div class="box-body">
                {{csrf_field()}}
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="tanggal_pendaftaran">Tanggal Pendaftaran</label>
                    <div class="col-sm-2">
                        <input id="tanggal_pendaftaran" name="tanggal_pendaftaran" class="form-control" type="text" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="no_ktp">Nomor KTP</label>
                    <div class="col-sm-5">
                        <input name="no_ktp" class="form-control" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="nama">Nama</label>
                    <div class="col-sm-5">
                        <input name="nama" class="form-control" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="umur">Umur</label>
                    <div class="col-sm-1">
                        <input name="umur" class="form-control number-input" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="kelamin">Jenis Kelamin</label>
                    <div class="col-sm-3">
                        <select name="kelamin" class="form-control">
                            <option value="L">Laki - Laki (L)</option>
                            <option value="P">Perempuan (P)</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="status">Status</label>
                    <div class="col-sm-3">
                        <select name="status" class="form-control">
                            <option value="Belum Kawin">Belum Kawin</option>
                            <option value="Kawin">Kawin</option>
                            <option value="Janda">Janda</option>
                            <option value="Duda">Duda</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="pendidikan">Pendidikan</label>
                    <div class="col-sm-5">
                        <input name="pendidikan" class="form-control" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="jurusan">Jurusan</label>
                    <div class="col-sm-5">
                        <input name="jurusan" class="form-control" type="text">
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
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="status_kerja">Status Kerja</label>
                    <div class="col-sm-3">
                        <select name="status_kerja" class="form-control">
                            <option value="Belum Bekerja">Belum Bekerja</option>
                            <option value="Bekerja">Bekerja</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="lokasi_kerja">Lokasi Kerja</label>
                    <div class="col-sm-5">
                        <textarea name="lokasi_kerja" class="form-control"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="gambar">Gambar</label>
                    <div class="col-sm-5">
                        <input name="gambar" class="form-control" type="file" accept="image/*">
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
        $('#tanggal_pendaftaran').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        }).datepicker('setDate', new Date())

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

          if (/[^0-9]+/g.test(input)) {
            var input = input.replace(/[^0-9]+/g, "")
            bootbox.alert('hanya angka yang diperbolehkan')
          }

        //   dotString = input.match(/[.]{1}/g)
        //   if (dotString != null && dotString.length > 1) {
        //     input = input.replace(/[\.]/, '')
        //   }

          // input = input ? Number( input ) : 0
          if (input.length > 1 && input.substr(0,1) == "0" && input.substr(1,1) != ".") {
            input = input.substr(1)
          }
          

          $this.val(function() {
              return (input === 0) ? "0" : input
          })
        })

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
    })

</script>