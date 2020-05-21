<section class="content-header">
    <h1>
        Laporan Buku Besar
    </h1>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <form id="filter" class="form-inline">
                <div class="form-group">
                    <label>Tanggal Mulai</label>
                    <input id="tanggal_mulai" name="tanggal_mulai" class="form-control" type="text" autocomplete="off">
                </div>
                <div class="form-group">
                    <label>Tanggal Selesai</label>
                    <input id="tanggal_selesai" name="tanggal_selesai" class="form-control" type="text" autocomplete="off">
                </div>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>

        <div class="box-body table-responsive">
            <table class="table table-bordered" style="width:100%">
                <thead>
                    <tr style="background-color: #3c8dbc; color: #ffffff">
                        <th style="width:10%">Tanggal</th>
                        <th>Keterangan</th>
                        <th>Debit</th>
                        <th>Kredit</th>
                        <th>Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($keuangan as $data)
                    <tr>
                        <td>{{$data->tanggal}}</td>
                        <td>{{ucfirst($data->keterangan)}}</td>
                        <td>{{($data->jenis == 'masuk')?$data->total_format:0}}</td>
                        <td>{{($data->jenis == 'keluar')?$data->total_format:0}}</td>
                        <td>{{$data->sisa_kas_format}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</section>

<script>
    var thisPath = "{{request()->url()}}";

    $('#tanggal_mulai').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true
    }).datepicker('setDate', '{{request()->get('tanggal_mulai') ?? $mulai}}')

    $('#tanggal_selesai').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true
    }).datepicker('setDate', '{{request()->get('tanggal_selesai') ?? $selesai}}')

    $(function() {
        $('#filter').submit(function(e) {
            e.preventDefault()
            routeMenu('get', thisPath, $(this).serialize())
        })
    })
</script>