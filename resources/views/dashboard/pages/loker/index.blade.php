<section class="content-header">
    <h1>
        Data Loker
        <small>Daftar Loker</small>
    </h1>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <div class="row">
                <div class="col-sm-6">
                    <button type="button" id="btn-create" class="btn btn-success">Tambah Data</button>
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
                        <th>ID</th>
                        <th>Judul</th>
                        <th>Kota</th>
                        <th>Jenis</th>
                        @if(auth()->user()->role_id == 1)
                        <th>Dibuat Oleh</th>
                        @endif
                        <th style="width:20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($loker as $data)
                    <tr>
                        <td>{{$data->id}}</td>
                        <td>{{$data->judul}}</td>
                        <td>{{$data->kota}}</td>
                        <td>
                            <ul>
                                @foreach($data->jenis_list as $j)
                                <li>{{$j}}</li>
                                @endforeach
                            </ul>
                        </td>
                        @if(auth()->user()->role_id == 1)
                        <td>{{$data->user->nama}}</td>
                        @endif
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#info{{$loop->index}}">Lihat</button>
                                <button type="button" class="btn btn-warning" data-id="{{$data->id}}">Edit</button>
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
                                    <h4 class="modal-title">{{$data->judul}}</h4>
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
                                                <label>Judul</label>
                                            </div>
                                            <div class="col-sm-9">
                                                {{$data->judul}}
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-3 text-right">
                                                <label>Kota</label>
                                            </div>
                                            <div class="col-sm-9">
                                                {{$data->kota}}
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-3 text-right">
                                                <label>Jenis</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <ul>
                                                    @foreach($data->jenis_list as $j)
                                                    <li>{{$j}}</li>
                                                    @endforeach
                                                </ul>
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
                                        @if(auth()->user()->role_id == 1)
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-3 text-right">
                                                <label>Dibuat Oleh</label>
                                            </div>
                                            <div class="col-sm-9">
                                                {{$data->user->nama}}
                                            </div>
                                        </div>
                                        @endif
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-3 text-right">
                                                <label>Deskripsi</label>
                                            </div>
                                            <div class="col-sm-9">
                                                {!!$data->deskripsi!!}
                                            </div>
                                        </div>
                                    </form>
                                    <div></div>
                                </div>

                                <div class="modal-footer">
                                    <a href="{{route('homepage.loker.detail', ['slug' => $data->judul_slug])}}" target="blank">
                                        <button type="button" class="btn btn-primary">Lihat di Web</button>
                                    </a>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                </div>
                                </div>
                            </div>
                        </div>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="box-tools pull-right">{{ $loker->appends(['search' => request()->get('search')])->links() }}</div>
            
        </div>
    </div>
</section>

<script>
    var thisPath = "{{request()->url()}}";

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