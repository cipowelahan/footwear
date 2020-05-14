<section class="content-header">
    <h1>
        Edit Data Supplier
        <small>Edit Data Supplier</small>
    </h1>
</section>

<section class="content">
    <div class="box">

        <form class="form-horizontal" method="POST">
            <div class="box-body">
                {{csrf_field()}}
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="status_martial">ID</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="text" name="id" value="{{$supplier->id}}" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="nama">Nama</label>
                    <div class="col-sm-5">
                        <input name="nama" class="form-control" type="text" value="{{$supplier->nama}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="no_hp">No HP</label>
                    <div class="col-sm-5">
                        <input name="no_hp" class="form-control" type="text" value="{{$supplier->no_hp}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="alamat">Alamat</label>
                    <div class="col-sm-5">
                        <textarea name="alamat" class="form-control">{{$supplier->alamat}}</textarea>
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
            var id = $('[name=id]').val();
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