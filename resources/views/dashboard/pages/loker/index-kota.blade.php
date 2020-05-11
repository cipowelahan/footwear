<section class="content-header">
    <h1>
        Daftar Kota Yang Sudah Dimasukkan
    </h1>
</section>

<section class="content">
    <div class="box">

        <div class="box-body table-responsive">
            <table class="table table-bordered" style="width:100%">
                <thead>
                    <tr style="background-color: #3c8dbc; color: #ffffff">
                        <th style="width:5%; text-align:center">No</th>
                        <th>Nama</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kota as $key => $value)
                    <tr>
                        <td style="text-align:center">{{$key+1}}</td>
                        <td>{{$value}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
    </div>
</section>