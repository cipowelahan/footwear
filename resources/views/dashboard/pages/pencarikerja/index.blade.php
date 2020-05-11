<section class="content-header">
    <h1>
        Data Pencari Kerja
        <small>Daftar Pencari Kerja</small>
    </h1>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <div class="row">
                <div class="col-sm-6">
                    <button type="button" id="btn-create" class="btn btn-success">Tambah Data</button>
                    <button type="button" id="btn-upload" class="btn btn-primary">Upload Data</button>
                </div>

                <div class="col-sm-6">
                    <div class="box-tools pull-right">
                        <form id="cari" method="POST" class="form-inline">
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
                                                    <div class="col-sm-6">Jenis Kelamin</div>
                                                    <div class="col-sm-6">
                                                        <select name="kelamin" class="form-control" style="width: 100%">
                                                            <option value="">Semua Kelamin</option>
                                                            <option value="L">Laki - Laki (L)</option>
                                                            <option value="P">Perempuan (P)</option>
                                                        </select>
                                                    </div>
                                                    <br>
                                                    <hr>
                                                    <div class="col-sm-6">Urutkan Berdasarkan</div>
                                                    <div class="col-sm-6">
                                                        <select name="order_column" class="form-control" style="width: 100%">
                                                            <option value="id">ID</option>
                                                            <option value="tanggal_pendaftaran">Tanggal Pendaftaran</option>
                                                            <option value="no_ktp">KTP</option>
                                                            <option value="nama">Nama</option>
                                                            <option value="kelamin">Kelamin</option>
                                                            <option value="umur">Umur</option>
                                                            <option value="pendidikan">Pendidikan</option>
                                                            <option value="status_kerja">Status Bekerja</option>
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
                            <div class="input-group" style="width: 250px;">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#boxfilter">Filter</button>
                                </span>
                                <input type="text" class="form-control" name="search" value="{{request()->get('search')}}">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit" id="cari-cari"><span class="fa fa-search"></span> Cari</button>
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
                        <th style="width:15%">Tanggal Pendaftaran</th>
                        <th>KTP</th>
                        <th>Nama</th>
                        <th>Kelamin</th>
                        <th>Umur</th>
                        <th>Kontak</th>
                        <th>Pendidikan</th>
                        <th>Status Bekerja</th>
                        @if(auth()->user()->role_id == 1)
                        <th>Dibuat Oleh</th>
                        @endif
                        <th style="width:20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pencarikerja as $data)
                    <tr>
                        <td>{{$data->id}}</td>
                        <td>{{$data->tanggal_pendaftaran}}</td>
                        <td>{{$data->no_ktp}}</td>
                        <td>{{$data->nama}}</td>
                        <td>{{$data->kelamin == 'L' ? 'Laki - Laki':'Perempuan'}}</td>
                        <td>{{$data->umur}}</td>
                        <td>{{$data->kontak}}</td>
                        <td>{{$data->pendidikan}}</td>
                        <td>{{$data->status_kerja}}</td>
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
                                                <label>Tanggal Pendaftaran</label>
                                            </div>
                                            <div class="col-sm-9">
                                                {{$data->tanggal_pendaftaran}}
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-3 text-right">
                                                <label>Nomor KTP</label>
                                            </div>
                                            <div class="col-sm-9">
                                                {{$data->no_ktp}}
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
                                                <label>Umur</label>
                                            </div>
                                            <div class="col-sm-9">
                                                {{$data->umur}}
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-3 text-right">
                                                <label>Jenis Kelamin</label>
                                            </div>
                                            <div class="col-sm-9">
                                                {{$data->kelamin == 'L' ? 'Laki - Laki':'Perempuan'}}
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-3 text-right">
                                                <label>Status</label>
                                            </div>
                                            <div class="col-sm-9">
                                                {{$data->status}}
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-3 text-right">
                                                <label>Pendidikan</label>
                                            </div>
                                            <div class="col-sm-9">
                                                {{$data->pendidikan}}
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-3 text-right">
                                                <label>Jurusan</label>
                                            </div>
                                            <div class="col-sm-9">
                                                {{$data->jurusan}}
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-3 text-right">
                                                <label>Alamat</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <textarea style="background-color: #fff0" class="form-control" rows="4" readonly>{{$data->alamat}}</textarea>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-3 text-right">
                                                <label>Kontak</label>
                                            </div>
                                            <div class="col-sm-9">
                                                {{$data->kontak}}
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-3 text-right">
                                                <label>Status Kerja</label>
                                            </div>
                                            <div class="col-sm-9">
                                                {{$data->status_kerja}}
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-3 text-right">
                                                <label>Lokasi Kerja</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <textarea style="background-color: #fff0" class="form-control" rows="4" readonly>{{$data->lokasi_kerja}}</textarea>
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

            <div class="box-tools pull-right">{{ $pencarikerja->appends(['search' => request()->get('search'), 
                                                                        'order_column' => request()->get('order_column'), 
                                                                        'order' => request()->get('order'), 
                                                                        'kelamin' => request()->get('kelamin')])->links() }}</div>
            
        </div>
    </div>
</section>

<script>
    var thisPath = "{{request()->url()}}";

    $('[name=order_column]').val('{{request()->get('order_column', 'id')}}')
    $('[name=order]').val('{{request()->get('order', 'asc')}}')
    $('[name=kelamin]').val('{{request()->get('kelamin')}}')

    function submitFilter() {
        setTimeout(function() {
            $('#cari-cari').trigger('click')
        }, 600)
    }

    $(function() {
        $('#btn-create').click(function() {
            routeMenu('get', thisPath+'/create')
        })

        $('#btn-upload').click(function() {
            routeMenu('get', thisPath+'/upload')
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