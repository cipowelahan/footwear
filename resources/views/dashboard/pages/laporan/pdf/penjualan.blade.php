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
<h4 class="title">Laporan Penjualan Barang</h4>
<h6 class="title">Untuk Periode {{$tanggal}}</h6>

<hr>

<table style="width: 100%">
    <thead>
        <tr style="background-color: #3c8dbc; color: #ffffff">
            <th style="width: 20%">Kode</th>
            <th>Nama</th>
            <th style="width: 10%; text-align: right">Jumlah</th>
            <th style="text-align: right">Total Harga</th>
        </tr>
    </thead>
    <tbody>
        @foreach($penjualan as $data)
        <tr>
            <td>{{$data->kode_produk}}</td>
            <td>{{$data->nama_produk}}</td>
            <td style="text-align: right">{{$data->sum_jumlah}}</td>
            <td style="text-align: right">{{number_format($data->sum_total)}}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr style="background-color: #3c8dbc; color: #ffffff">
            <th colspan="2" style="text-align: right">TOTAL SEMUA</th>
            <th id="total-jumlah" style="text-align: right">{{$jumlah}}</th>
            <th id="total-harga" style="text-align: right">{{number_format($harga)}}</th>
        </tr>
    </tfoot>
</table>