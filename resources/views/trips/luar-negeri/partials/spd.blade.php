<table>
    <tr>
        <td width="15%">
            <img src="{{ public_path('logo.png') }}" width="80">
        </td>

        <td class="text-center">
            <h3>KEMENTERIAN LUAR NEGERI</h3>
            <h4>REPUBLIK INDONESIA</h4>
            <p>Jl. Pejambon No. 6 Jakarta</p>
        </td>
    </tr>
</table>

<hr>

<div class="title text-center">
    SURAT PERJALANAN DINAS LUAR NEGERI
</div>

<table>
    <tr>
        <td width="35%">Nomor Surat</td>
        <td>: {{ $trip->nomor_surat }}</td>
    </tr>

    <tr>
        <td>Nama</td>
        <td>: {{ $trip->nama }}</td>
    </tr>

    <tr>
        <td>NIP</td>
        <td>: {{ $trip->nip }}</td>
    </tr>

    <tr>
        <td>Jabatan</td>
        <td>: {{ $trip->jabatan }}</td>
    </tr>

    <tr>
        <td>Tujuan Negara</td>
        <td>: {{ $trip->tujuan }}</td>
    </tr>

    <tr>
        <td>Maksud Perjalanan</td>
        <td>: {{ $trip->maksud_perjalanan }}</td>
    </tr>

    <tr>
        <td>Tanggal Berangkat</td>
        <td>: {{ $trip->tanggal_keberangkatan }}</td>
    </tr>

    <tr>
        <td>Tanggal Kembali</td>
        <td>: {{ $trip->tanggal_kembali }}</td>
    </tr>

    <tr>
        <td>Lama Perjalanan</td>
        <td>: {{ $trip->lama_hari }} Hari</td>
    </tr>

    <tr>
        <td>Jenis Angkutan</td>
        <td>: {{ strtoupper($trip->jenis_angkutan) }}</td>
    </tr>
</table>

<br><br>

<table>
    <tr>
        <td width="60%"></td>

        <td class="text-center">
            Jakarta,

            <br><br><br><br>

            <b>Pejabat Pembuat Komitmen</b>
        </td>
    </tr>
</table>