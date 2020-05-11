<section class="content-header">
    <h1>
        Upload Data Pencari Kerja
        <small>Upload Data Pencari Kerja</small>
    </h1>
</section>

<section class="content">
    <div class="box">

        <form class="form-horizontal" method="POST" enctype="multipart/form-data">
            <div class="box-body">
                {{csrf_field()}}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="file">File Data Pencari Kerja</label>
                    <div class="col-sm-5">
                        <input type="file" name="file" accept=".xls,.xlsx,.csv" required>
                    </div>
                    <div class="col-sm-3">
                        * Jika masih terjadi error pada saat upload file excel, silahkan gunakan format
                        excel berikut, guna untuk menghindari kesalahan sistem.
                        <br>
                        <a href="{{asset('example.xls')}}">Contoh Format File</a>
                    </div>
                </div>
            </div>
    
            <div class="box-footer">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for=""></label>
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
        routeMenu('get', thisPath.replace("/upload", ""));
    }

    $(function() {
        $('form').submit(function(e) {
            e.preventDefault();
            loader('show')
            var data = new FormData();

            data.append('_token', $('[name=_token]').val())
            data.append('file', $('[name=file]')[0].files[0])

            $.ajax({
                method: 'post',
                url: thisPath,
                data: data,
                processData: false, 
                contentType: false,
                success: function(result) {
                    if (result == "1") {
                        routeMenu('get', thisPath.replace("/upload", ""));
                        notification('berhasil', 'success');
                    }
                },
                error: function(error) {
                    loader('hide')
                    notification(error.statusText, 'error')
                }
            });
        })
    })
</script>