<section class="content-header">
    <h1>
        Data Keuangan Kas
        <small>Daftar Keuangan Kas</small>
    </h1>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <div class="row">
                <div class="col-sm-6">
                    {{-- <button type="button" id="btn-create" class="btn btn-success">Tambah Data</button> --}}
                </div>

                <div class="col-sm-6">
                    <div class="box-tools pull-right">
                        <form id="cari" method="POST">

                            <!-- Modal filter -->
                            <div class="input-group">
                                <div class="modal fade" tabindex="-1" role="dialog" id="boxfilter">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">

                                            <div class="modal-header btn-primary">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Filter Pencarian</h4>
                                            </div>

                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-6">Tanggal Mulai</div>
                                                    <div class="col-sm-6">
                                                        <input id="tanggal_mulai" name="tanggal_mulai" class="form-control" type="text" autocomplete="off">
                                                    </div>
                                                    <br>
                                                    <br>
                                                    <div class="col-sm-6">Tanggal Selesai</div>
                                                    <div class="col-sm-6">
                                                        <input id="tanggal_selesai" name="tanggal_selesai" class="form-control" type="text" autocomplete="off">
                                                    </div>
                                                    <br>
                                                    <br>
                                                    <hr>
                                                    <div class="col-sm-6">Keterangan</div>
                                                    <div class="col-sm-6">
                                                        <select name="keterangan" class="form-control" style="width: 100%">
                                                            <option value="">Semua Keterangan</option>
                                                            <option value="asset">Asset</option>
                                                            <option value="kas">Kas</option>
                                                            <option value="transaksi">Transaksi</option>
                                                        </select>
                                                    </div>
                                                    <br>
                                                    <hr>
                                                    <div class="col-sm-6">Urutkan Berdasarkan</div>
                                                    <div class="col-sm-6">
                                                        <select name="order_column" class="form-control" style="width: 100%">
                                                            <option value="tanggal">Tanggal</option>
                                                            <option value="jenis">Jenis</option>
                                                            <option value="total">Total</option>
                                                        </select>
                                                    </div>
                                                    <br>
                                                    <br>
                                                    <div class="col-sm-6">Urutkan Besar/Abjad</div>
                                                    <div class="col-sm-6">
                                                        <select name="order" class="form-control" style="width: 100%">
                                                            <option value="asc">Kecil - Besar ( A - Z )</option>
                                                            <option value="desc">Besar - Kecil ( Z - A )</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="submitFilter()">Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Modal filter -->

                            <!-- Box Search -->
                            <div class="input-group" style="width: 250px;">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#boxfilter">Filter</button>
                                </span>
                                <input type="text" class="form-control" name="search" value="{{request()->get('search')}}">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit" id="cari-cari"><span class="fa fa-search"></span> Cari</button>
                                </span>
                            </div>
                            <!-- End Box Search -->

                        </form>
                    </div>
                </div>

            </div>

        </div>

        <div class="box-body table-responsive">
            <table class="table table-bordered" style="width:100%">
                <thead>
                    <tr style="background-color: #3c8dbc; color: #ffffff">
                        <th style="width:10%">Tanggal</th>
                        <th style="width:10%">Jenis</th>
                        <th>Total</th>
                        <th style="width:20%">Keterangan</th>
                        <th style="width:10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($keuangan as $data)
                    <tr>
                        <td>{{$data->tanggal}}</td>
                        <td>{{ucfirst($data->jenis)}}</td>
                        <td>{{$data->total_format}}</td>
                        <td>{{$data->keterangan}}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#info{{$loop->index}}">Lihat</button>
                                {{-- <button type="button" class="btn btn-warning" data-id="{{$data->id}}">Edit</button>
                                <button type="button" class="btn btn-danger" data-id="{{$data->id}}">Hapus</button> --}}
                            </div>
                        </td>
                    </tr>
                    <tr style="display: none">
                        <div class="modal fade" tabindex="-1" role="dialog" id="info{{$loop->index}}">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">

                                <div class="modal-header btn-primary">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">{{$data->nama}}</h4>
                                </div>

                                <div class="modal-body">
                                    <form class="form-horizontal">
                                        <div class="row">
                                            <div class="col-sm-3 text-right">
                                                <label>ID</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" value="{{$data->id}}" readonly>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-3 text-right">
                                                <label>Tanggal</label>
                                            </div>
                                            <div class="col-sm-9">
                                                {{$data->tanggal}}
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-3 text-right">
                                                <label>Jenis</label>
                                            </div>
                                            <div class="col-sm-9">
                                                {{ucfirst($data->jenis)}}
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-3 text-right">
                                                <label>Total</label>
                                            </div>
                                            <div class="col-sm-9">
                                                {{$data->total_format}}
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-3 text-right">
                                                <label>Keterangan</label>
                                            </div>
                                            <div class="col-sm-9">
                                                {{ucfirst($data->keterangan)}}
                                            </div>
                                        </div>
                                        <hr>
                                        <p class="text-center">Detail</p>
                                        <div class="row">
                                            <div class="col-sm-3 text-right">
                                                <label>ID</label>
                                            </div>
                                            <div class="col-sm-9">
                                                {{$data->{$data->keterangan}->id}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3 text-right">
                                                <label>Tanggal</label>
                                            </div>
                                            <div class="col-sm-9">
                                                {{$data->{$data->keterangan}->tanggal}}
                                            </div>
                                        </div>
                                        @if($data->keterangan != 'transaksi')
                                        <div class="row">
                                            <div class="col-sm-3 text-right">
                                                <label>Nama</label>
                                            </div>
                                            <div class="col-sm-9">
                                                {{$data->{$data->keterangan}->nama}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3 text-right">
                                                <label>Kategori</label>
                                            </div>
                                            <div class="col-sm-9">
                                                {{$data->{$data->keterangan}->kategori->nama}}
                                            </div>
                                        </div>
                                        @endif
                                        @if($data->keterangan != 'asset')
                                        <div class="row">
                                            <div class="col-sm-3 text-right">
                                                <label>Jenis</label>
                                            </div>
                                            <div class="col-sm-9">
                                                {{ucfirst($data->{$data->keterangan}->jenis)}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3 text-right">
                                                <label>Total/Harga</label>
                                            </div>
                                            <div class="col-sm-9">
                                                {{$data->{$data->keterangan}->total_format}}
                                            </div>
                                        </div>
                                        @else
                                        <div class="row">
                                            <div class="col-sm-3 text-right">
                                                <label>Total/Harga</label>
                                            </div>
                                            <div class="col-sm-9">
                                                {{$data->{$data->keterangan}->harga_beli_format}}
                                            </div>
                                        </div>
                                        @endif
                                    </form>
                                    <div></div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                </div>
                                </div>
                            </div>
                        </div>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="box-tools pull-right">{{ $keuangan->appends(['search' => request()->get('search'), 
                                                                    'order_column' => request()->get('order_column'), 
                                                                    'order' => request()->get('order'),
                                                                    'tanggal_mulai' => request()->get('tanggal_mulai'),
                                                                    'tanggal_selesai' => request()->get('tanggal_selesai'),
                                                                    'keterangan' => request()->get('keterangan')])->links()}}</div>
            
        </div>
    </div>
</section>

<script>
    var thisPath = "{{request()->url()}}";

    $('[name=order_column]').val('{{request()->get('order_column', 'tanggal')}}')
    $('[name=order]').val('{{request()->get('order', 'desc')}}')

    $('#tanggal_mulai').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true
    }).datepicker('setDate', '{{request()->get('tanggal_mulai') ?? ''}}')

    $('#tanggal_selesai').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true
    }).datepicker('setDate', '{{request()->get('tanggal_selesai') ?? ''}}')

    function submitFilter() {
        setTimeout(function() {
            $('#cari-cari').trigger('click')
        }, 600)
    }

    $(function() {
        $('#btn-create').click(function() {
            routeMenu('get', thisPath+'/create')
        })

        $('ul.pagination li a').click(function() {
            event.preventDefault();
            routeMenu('get', $(this).attr('href'))
        })

        $('table tbody tr td div button.btn-warning').click(function(e) {
            e.preventDefault()
            var id = $(this).attr('data-id')
            bootbox.confirm('Yakin Mengedit ?', function(ok) {
                if(ok) {
                    routeMenu('get', thisPath+'/edit', { id })
                }
            })
        })

        $('table tbody tr td div button.btn-danger').click(function(e) {
            e.preventDefault()
            var id = $(this).attr('data-id')
            bootbox.confirm('Yakin Menghapus ?', function(ok) {
                if(ok) {
                    routeMenu('post', thisPath+'/delete', { 
                        id,
                        _token: "{{csrf_token()}}",
                        lastUrl: "{{request()->fullUrl()}}"
                    }, function(result) {
                        if (result.succes) {
                            routeMenu('get', result.lastUrl);
                            notification('berhasil', 'success');
                        } 
                    })
                }
            })
        })

        $('#cari').submit(function(e) {
            e.preventDefault()
            routeMenu('get', thisPath, $(this).serialize())
        })
    })
</script>