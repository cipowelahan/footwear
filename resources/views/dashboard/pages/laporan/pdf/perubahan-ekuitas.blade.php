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
<h4 class="title">Laporan Perubahan Ekuitas</h4>
<h6 class="title">Untuk Periode {{$tanggal}}</h6>

<hr>

<table style="width: 100%">
    <tr>
        <th style="width: 40%">Laba Ditahan Awal</th>
        <td>{{number_format($laba_rugi_lalu)}}</td>
    </tr>
    <tr>
        <th>Laba Ditahan Periode</th>
        <td>{{number_format($laba_rugi_sekarang)}}</td>
    </tr>
    <tr>
        <th style="text-align: right">Laba Yang Tersedia</th>
        <th style="text-align: right">{{number_format($laba_rugi_tersedia)}}</th>
    </tr>
    <tr>
        <th>Prive</th>
        <td>({{number_format($prive)}})</td>
    </tr>
    <tr>
        <th style="text-align: right">Laba Ditahan Akhir</th>
        <th style="text-align: right">{{number_format($laba_rugi_akhir)}}</th>
    </tr>
</table>