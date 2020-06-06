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
<h4 class="title">Laporan Neraca Keuangan</h4>
<h6 class="title">Untuk Periode {{$tanggal}}</h6>

<hr>

<table style="width: 100%">
    <tr>
        <th colspan="2" style="text-align: center">AKTIVA</th>
    </tr>
    <tr>
        <th>Kas</th>
        <td>{{number_format($kas)}}</td>
    </tr>
    <tr>
        <th>Persediaan</th>
        <td>{{number_format($persediaan)}}</td>
    </tr>
    <tr>
        <th>Asset</th>
        <td>{{number_format($asset)}}</td>
    </tr>
    <tr>
        <th style="text-align: right">Total</th>
        <th style="text-align: right">{{number_format($aktiva)}}</th>
    </tr>
</table>

<table style="width: 100%">
    <tr>
        <th colspan="2" style="text-align: center">PASIVA</th>
    </tr>
    <tr>
        <th>Modal</th>
        <td>{{number_format($modal)}}</td>
    </tr>
    <tr>
        <th>Laba Ditahan</th>
        <td>{{number_format($laba_rugi_akhir)}}</td>
    </tr>
    <tr>
        <th style="text-align: right">Total</th>
        <th style="text-align: right">{{number_format($pasiva)}}</th>
    </tr>
</table>