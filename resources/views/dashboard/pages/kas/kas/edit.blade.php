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
        Edit Data Kas
        <small>Edit Data Kas</small>
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
                        <input class="form-control" type="text" name="id" value="{{$kas->id}}" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="tanggal">Tanggal</label>
                    <div class="col-sm-5">
                        <input id="tanggal" name="tanggal" class="form-control" type="text" autocomplete="off" value="{{$kas->tanggal}}" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="jenis">Jenis</label>
                    <div class="col-sm-5">
                        <select name="jenis" id="jenis" class="form-control">
                            <option value="pengeluaran">Pengeluaran</option>
                            <option value="pemasukan">Pemasukan</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="kategori_id">Kategori</label>
                    <div class="col-sm-5">
                        <select name="kategori_id" id="kategori" class="form-control">
                            @foreach($kategori as $k)
                            <option value="{{$k->id}}" @if($k->id == $kas->kategori_id) selected @endif >{{$k->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="nama">Nama</label>
                    <div class="col-sm-5">
                        <input name="nama" class="form-control" type="text" value="{{$kas->nama}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="harga_beli">Harga</label>
                    <div class="col-sm-5">
                        <input name="total" class="form-control number-input" type="text" value="{{$kas->total_format}}" readonly>
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

    $('[name=jenis]').val('{{$kas->jenis}}')

    $('select').select2()

    // $('#tanggal').datepicker({
    //   format: 'yyyy-mm-dd',
    //   autoclose: true
    // })

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

            input = input.replace(/[\D\s\._\-]+/g, "")
            input = input ? parseInt( input, 10 ) : 0

            $this.val(function() {
                return (input === 0) ? "0" : input.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
            })
        })

    })

</script>