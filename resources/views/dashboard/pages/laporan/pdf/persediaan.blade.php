<style>
    table, th, td {
      border: 1px solid black;
      border-collapse: collapse;
      width: 50%;
      text-align: left;
      padding: 5
    }

    .title {
        text-align: center;
        margin: 0;
        padding: 0;
    }
</style>

<h1 class="title">ENDAR FOOT WEAR</h1>
<h4 class="title">Laporan Persediaan Barang</h4>
<h6 class="title">Untuk Periode {{$tanggal}}</h6>

<hr>

<table style="width: 100%">
    <thead>
        <tr style="background-color: #3c8dbc; color: #ffffff">
            <th>Kode</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Merk</th>
            <th>Stok</th>
            <th>Harga Beli</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($persediaan as $data)
        <tr>
            <td>{{$data->kode}}</td>
            <td>{{$data->nama}}</td>
            <td>{{@$data->kategori->nama}}</td>
            <td>{{$data->merk}}</td>
            <td>{{$data->stok}}</td>
            <td>{{$data->harga_beli_format}}</td>
            <td>{{$data->total}}</td>
        </tr>
        @endforeach
    </tbody>
</table>