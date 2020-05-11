<section class="content-header">
    <h1>
        Download Data Pencari Kerja
        <small>Download Data Pencari Kerja</small>
    </h1>
</section>

<section class="content">
    <div class="box">

        <form class="form-horizontal" method="POST" action="{{request()->url()}}" target="blank">
            <div class="box-body">
                {{csrf_field()}}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="file">Tanggal Pendaftaran</label>
                    <div class="col-sm-3">
                        <select id="tanggal_pendaftaran" name="tanggal_pendaftaran" class="form-control">
                            @foreach($tanggal_pendaftaran as $tanggal)
                            <option value="{{$tanggal}}">{{$tanggal}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
    
            <div class="box-footer">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for=""></label>
                    <div class="col-sm-5">
                        <button class="btn btn-primary" type="submit">Download</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    $(function() {
        $('#tanggal_pendaftaran').select2()
    })
</script>