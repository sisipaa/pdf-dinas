<table>
    <tr>
        <td width="15%">
            @php $logoPath = public_path('logo.png'); @endphp
            @if(file_exists($logoPath))
                <img src="{{ imageToBase64($logoPath) }}" width="80">
            @endif
        </td>
        <td class="text-center">
            <h3>BADAN KARANTINA INDONESIA</h3>
            <p>Jl. Harsono RM No. 3, Jakarta Selatan</p>
        </td>
    </tr>
</table>

<hr>

<div class="title text-center">
    SURAT PERJALANAN DINAS LUAR NEGERI
</div>

<table>
    <tr><td width="35%">Nomor Surat</td><td>: {{ $trip->nomor_surat ?? '-' }}</td></tr>
    <tr><td>Nama</td><td>: {{ $trip->nama }}</td></tr>
    <tr><td>NIP</td><td>: {{ $trip->nip }}</td></tr>
    <tr><td>Jabatan</td><td>: {{ $trip->jabatan }}</td></tr>
    <tr><td>Tujuan Negara</td><td>: {{ $trip->tujuan }}</td></tr>
    <tr><td>Maksud Perjalanan</td><td>: {{ $trip->maksud_perjalanan }}</td></tr>
    <tr><td>Tanggal Berangkat</td><td>: {{ \Carbon\Carbon::parse($trip->tanggal_keberangkatan)->format('d F Y') }}</td></tr>
    <tr><td>Tanggal Kembali</td><td>: {{ \Carbon\Carbon::parse($trip->tanggal_kembali)->format('d F Y') }}</td></tr>
    <tr><td>Lama Perjalanan</td><td>: {{ $trip->lama_hari }} Hari</td></tr>
    <tr><td>Jenis Angkutan</td><td>: {{ strtoupper($trip->jenis_angkutan) }}</td></tr>
</table>

<br><br>

<table>
    <tr>
        <td width="60%"></td>
        <td class="text-center">
            Jakarta, {{ \Carbon\Carbon::now()->format('d F Y') }}
            <br><br><br><br>
            <b>Pejabat Pembuat Komitmen</b>
        </td>
    </tr>
</table>