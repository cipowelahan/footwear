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
<h4 class="title">Laporan Laba Rugi Komprehensif</h4>
<h6 class="title">Untuk Periode {{$tanggal}}</h6>

<hr>

<table style="width: 100%">
    <tr>
        <th>Penjualan</th>
        <td>{{number_format($penjualan)}}</td>
    </tr>
    <tr>
        <th>Potongan Penjualan</th>
        <td>({{number_format($potongan_penjualan)}})</td>
    </tr>
    <tr>
        <th style="text-align: right">Penjualan Bersih</th>
        <th style="text-align: right">{{number_format($penjualan_bersih)}}</th>
    </tr>
    <tr>
        <th>HPP</th>
        <td>({{number_format($hpp)}})</td>
    </tr>
    <tr>
        <th style="text-align: right">Laba Kotor</th>
        <th style="text-align: right">{{number_format($laba_kotor)}}</th>
    </tr>
    <tr>
        <th>Beban Utilitas</th>
        <td>({{number_format($beban_utilitas)}})</td>
    </tr>
    <tr>
        <th>Beban Iklan</th>
        <td>({{number_format($beban_iklan)}})</td>
    </tr>
    <tr>
        <th>Beban Sewa</th>
        <td>({{number_format($beban_sewa)}})</td>
    </tr>
    <tr>
        <th>Beban Pemeliharaan dan Perbaikan</th>
        <td>({{number_format($beban_pemeliharaan)}}<</td>
    </tr>
    <tr>
        <th>Beban Gaji</th>
        <td>({{number_format($beban_gaji)}})</td>
    </tr>
    <tr>
        <th>Beban Perlengkapan</th>
        <td>({{number_format($beban_perlengkapan)}})</td>
    </tr>
    <tr>
        <th style="text-align: right">Laba Bersih</th>
        <th style="text-align: right">{{number_format($laba_bersih)}}</th>
    </tr>
</table>