<section class="content-header">
    <h1>
        Data Pengaduan
        <small>Daftar Pengaduan</small>
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
                            <div class="input-group" style="width: 200px;">
                                <input type="text" class="form-control" name="search" value="{{request()->get('search')}}">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit"><span class="fa fa-search"></span> Cari</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </div>

        <div class="box-body table-responsive">
            <table class="table table-bordered" style="width:100%">
                <thead>
                    <tr style="background-color: #3c8dbc; color: #ffffff">
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Nomor HP/Telp</th>
                        <th>Pesan</th>
                        <th>Status</th>
                        <th>Waktu</th>
                        <th style="width:20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengaduan as $data)
                    <tr>
                        <td>{{$data->nama}}</td>
                        <td>{{$data->email}}</td>
                        <td>{{$data->phone}}</td>
                        <td>{{$data->pesan}}</td>
                        <td>{{$data->status_teks}}</td>
                        <td>{{$data->created_at}}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#info{{$loop->index}}">Lihat</button>
                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#status{{$loop->index}}" data-id="{{$data->id}}">Status</button>
                                <button type="button" class="btn btn-danger" data-id="{{$data->id}}">Hapus</button>
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
                                                <label>Nama</label>
                                            </div>
                                            <div class="col-sm-9">
                                                {{$data->nama}}
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-3 text-right">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-sm-9">
                                                {{$data->email}}
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-3 text-right">
                                                <label>Nomor HP/Telp</label>
                                            </div>
                                            <div class="col-sm-9">
                                                {{$data->phone}}
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-3 text-right">
                                                <label>Gambar</label>
                                            </div>
                                            <div class="col-sm-9">
                                                @if($data->gambar)
                                                <img src="{{asset($data->gambar)}}" class="img-thumbnail">
                                                @else
                                                Belum di Upload
                                                @endif
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-3 text-right">
                                                <label>Pesan</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <textarea style="background-color: #fff0" class="form-control" rows="4" readonly>{{$data->pesan}}</textarea>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-3 text-right">
                                                <label>Status</label>
                                            </div>
                                            <div class="col-sm-9">
                                                {{$data->status_teks}}
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-3 text-right">
                                                <label>Waktu</label>
                                            </div>
                                            <div class="col-sm-9">
                                                {{$data->created_at}}
                                            </div>
                                        </div>
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
                    <tr style="display: none">
                        <div class="modal fade" tabindex="-1" role="dialog" id="status{{$loop->index}}">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">

                                <div class="modal-header btn-primary">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Ubah Status</h4>
                                </div>

                                <div class="modal-body">
                                    <form class="form-horizontal" id="form-update-{{$loop->index}}" action="" method="POST">
                                        <div class="row">
                                            <div class="col-sm-3 text-right">
                                                <label>Status</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input id="status-id-{{$loop->index}}" type="hidden" name="id" value="{{$data->id}}">
                                                <select id="status-status-{{$loop->index}}" name="status" class="form-control">
                                                    <option value="0" @if($data->status == 0) selected @endif>Ditolak</option>
                                                    <option value="1" @if($data->status == 1) selected @endif>Belum Diproses</option>
                                                    <option value="2" @if($data->status == 2) selected @endif>Sedang Diproses</option>
                                                    <option value="3" @if($data->status == 3) selected @endif>Selesai</option>
                                                </select>
                                            </div>
                                            <br>
                                            <br>
                                            <div class="col-sm-3 text-right">
                                            </div>
                                            <div class="col-sm-9">
                                                <button type="button" class="btn btn-warning" data-dismiss="modal" onclick="updateStatus('{{$loop->index}}')">Ubah</button>
                                            </div>
                                        </div>
                                        <br>
                                    </form>
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

            <div class="box-tools pull-right">{{ $pengaduan->appends(['search' => request()->get('search')])->links() }}</div>
            
        </div>
    </div>
</section>

<script>
    var thisPath = "{{request()->url()}}";

    function updateStatus(id) {
        var statusId, statusStatus, token, lastUrl
        statusId = $(`#status-id-${id}`).val()
        statusStatus = $(`#status-status-${id}`).val()
        token = "{{csrf_token()}}"
        lastUrl = "{{request()->fullUrl()}}"

        bootbox.confirm('Yakin Mengubah Status ?', function(ok) {
            if (ok) {
                routeMenu('post', thisPath+'/updateStatus', {
                    id: statusId,
                    status: statusStatus,
                    _token: token,
                    lastUrl
                }, function(result) {
                    if (result.succes) {
                        routeMenu('get', result.lastUrl);
                        notification('berhasil', 'success');
                    }
                })

            }
        })

    }

    $(function() {
        $('ul.pagination li a').click(function() {
            event.preventDefault();
            routeMenu('get', $(this).attr('href'))
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