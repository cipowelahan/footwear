<section class="content-header">
    <h1>
        Daftar Role
    </h1>
</section>

<section class="content">
    <div class="box">

        <div class="box-body table-responsive">
            <table class="table table-bordered" style="width:100%">
                <thead>
                    <tr style="background-color: #3c8dbc; color: #ffffff">
                        <th style="width:5%; text-align:center">ID</th>
                        <th>Nama</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($role as $r)
                    <tr>
                        <td style="text-align:center">{{$r->id}}</td>
                        <td>{{$r->nama}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
    </div>
</section>