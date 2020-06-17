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

<table style="width:100%">
    <thead>
        <tr style="background-color: #3c8dbc; color: #ffffff">
            <th rowspan="2" style="text-align: center; vertical-align: middle;">Kode Produk</th>
            <th colspan="6" style="text-align: center;">Nama Produk</th>
        </tr>
        <tr style="background-color: #3c8dbc; color: #ffffff">
            <th style="text-align: center">ID</th>
            <th style="text-align: center">Tanggal</th>
            <th style="text-align: center">User</th>
            <th style="text-align: right">Harga</th>
            <th style="text-align: right">Jumlah</th>
            <th style="text-align: right">Total Harga</th>
        </tr>
    </thead>
    <tbody>
        @foreach($penjualan as $data)
        <tr>
            <th style="text-align: center; width: 15%;">{{$data->kode_produk}}</th>
            <th colspan="6" style="text-align: center">{{$data->nama_produk}}</th>
        </tr>
        @foreach($data->list_transaksi as $transaksi)
        <tr>
            <td></td>
            <td style="text-align: center; width: 5%;">{{$transaksi->id}}</td>
            <td style="text-align: center; width: 10%;">{{$transaksi->tanggal}}</td>
            <td style="text-align: center; width: 15%;">{{$transaksi->user}}</td>
            <td style="text-align: right">{{$transaksi->harga}}</td>
            <td style="text-align: right">{{$transaksi->jumlah}}</td>
            <td style="text-align: right">{{$transaksi->total_format}}</td>
        </tr>
        @endforeach
        <tr>
            <th colspan="5" style="text-align: right">TOTAL</th>
            <th style="text-align: right">{{$data->sum_jumlah}}</th>
            <th style="text-align: right">{{$data->sum_total_format}}</th>
        </tr>
        <tr>
            <td colspan="7" style="background-color: gray"></td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr style="background-color: #3c8dbc; color: #ffffff">
            <th colspan="5" style="text-align: right">TOTAL SEMUA</th>
            <th style="text-align: right">{{$jumlah}}</th>
            <th style="text-align: right">{{number_format($harga)}}</th>
        </tr>
        <tr style="background-color: #3c8dbc; color: #ffffff">
            <th colspan="6" style="text-align: right">TOTAL DISKON TRANSAKSI</th>
            <th id="total-diskon" style="text-align: right">({{number_format($diskon)}})</th>
        </tr>
        <tr style="background-color: #3c8dbc; color: #ffffff">
            <th colspan="6" style="text-align: right">TOTAL PENJUALAN</th>
            <th id="total-penjualan" style="text-align: right">{{number_format($harga - $diskon)}}</th>
        </tr>
    </tfoot>
</table>