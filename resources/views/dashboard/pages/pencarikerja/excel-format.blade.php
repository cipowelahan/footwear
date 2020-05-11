<table>
    <tr>
        <td colspan="13" height="20" style="text-align: center; font-size: 15pt"><b>LAPORAN DAFTAR PENCAKER</b></td>
    </tr>
    <tr>
        <td colspan="13" height="20" style="text-align: center; font-size: 15pt"><b>TANGGAL PENDAFTARAN : {{$tanggal_teks}}</b></td>
    </tr>
    <tr></tr>
    <tr>
        <td align="center" width="5" style="border: 1px solid #000000"><b>NO</b></td>
        <td align="center" width="30" style="border: 1px solid #000000"><b>TANGGAL PENDAFTARAN</b></td>
        <td align="center" width="30" style="border: 1px solid #000000"><b>NO KTP</b></td>
        <td align="center" width="30" style="border: 1px solid #000000"><b>NAMA</b></td>
        <td align="center" width="10" style="border: 1px solid #000000"><b>UMUR</b></td>
        <td align="center" width="10" style="border: 1px solid #000000"><b>KELAMIN</b></td>
        <td align="center" width="15" style="border: 1px solid #000000"><b>STATUS</b></td>
        <td align="center" width="30" style="border: 1px solid #000000"><b>PENDIDIKAN</b></td>
        <td align="center" width="30" style="border: 1px solid #000000"><b>JURUSAN</b></td>
        <td align="center" width="30" style="border: 1px solid #000000"><b>ALAMAT</b></td>
        <td align="center" width="15" style="border: 1px solid #000000"><b>KONTAK</b></td>
        <td align="center" width="16" style="border: 1px solid #000000"><b>STATUS BEKERJA</b></td>
        <td align="center" width="30" style="border: 1px solid #000000"><b>LOKASI BEKERJA</b></td>
    </tr>
    @foreach($pencarikerja as $data)
    <tr>
        <td style="border: 1px solid #000000">{{$data['no']}}</td>
        <td style="border: 1px solid #000000">{{$data['tanggal_pendaftaran']}}</td>
        <td align="left" style="border: 1px solid #000000">{{$data['no_ktp']}}</td>
        <td style="border: 1px solid #000000">{{$data['nama']}}</td>
        <td style="border: 1px solid #000000">{{$data['umur']}}</td>
        <td style="border: 1px solid #000000">{{$data['kelamin']}}</td>
        <td style="border: 1px solid #000000">{{$data['status']}}</td>
        <td style="border: 1px solid #000000">{{$data['pendidikan']}}</td>
        <td style="border: 1px solid #000000">{{$data['jurusan']}}</td>
        <td style="border: 1px solid #000000">{{$data['alamat']}}</td>
        <td style="border: 1px solid #000000">{{$data['kontak']}}</td>
        <td style="border: 1px solid #000000">{{$data['status_kerja']}}</td>
        <td style="border: 1px solid #000000">{{$data['lokasi_kerja']}}</td>
    </tr>
    @endforeach
</table>