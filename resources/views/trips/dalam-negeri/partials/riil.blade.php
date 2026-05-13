<div class="judul">
  Yang bertanda tangan di bawah ini :
    DAFTAR PENGELUARAN RIIL
</div>

<hr>



<br><br>

<table>
    <tr>
        <td width="20%">Nama</td>
        <td width="2%">:</td>
        <td>{{ $trip->nama }}</td>
    </tr>

    <tr>
        <td>NIP</td>
        <td>:</td>
        <td>{{ $trip->nip }}</td>
    </tr>

    <tr>
        <td>Pangkat/Gol</td>
        <td>:</td>
        <td>{{ $trip->pangkat }} {{ $trip->golongan }}</td>
    </tr>

    <tr>
        <td>Jabatan</td>
        <td>:</td>
        <td>{{ $trip->jabatan }}</td>
    </tr>
</table>

<br>

Berdasarkan Surat Perintah Perjalanan Dinas (SPPD) tanggal
{{ \Carbon\Carbon::parse($trip->tanggal_keberangkatan)->translatedFormat('d F Y') }}
Nomor : {{ $trip->nomor_surat ?? '-' }},

dengan ini menyatakan dengan sesungguhnya bahwa :

<br><br>

1. Biaya transport pegawai dan/atau biaya penginapan di bawah ini yang tidak dapat diperoleh bukti-bukti pengeluarannya, meliputi :

<br><br>

<table class="border">
    <tr>
        <th width="10%">No</th>
        <th>URAIAN</th>
        <th width="30%">JUMLAH</th>
    </tr>

    <tr>
        <td class="center">1</td>
        <td>
            Transport {{ ucfirst($trip->jenis_angkutan) }} dari {{ $trip->tempat_keberangkatan }} - {{ $trip->tujuan }} PP
        </td>
</table>