<div class="center">
    @php
        $logoPath = public_path('logo.png');
        $qrPath = public_path('qr.png');
    @endphp
    
    @if(file_exists($logoPath))
        <img src="{{ imageToBase64($logoPath) }}" width="80"><br>
    @endif
    <b>BADAN KARANTINA INDONESIA</b><br>
    Jl. Harsono RM No. 3 Jakarta Selatan
</div>

<hr>

<div class="center">
<b>SURAT PERJALANAN DINAS (SPD)</b><br>
Nomor: {{ $trip->nomor_surat ?? '-' }}
</div>

<br>

<table>
    <tr><td width="5%">1.</td><td width="25%">Pejabat Pembuat Komitmen</td><td>:</td><td>.................................</td></tr>
    <tr><td>2.</td><td>Nama / NIP</td><td>:</td><td>{{ $trip->nama }} / {{ $trip->nip }}</td></tr>
    <tr><td>3.</td><td>Pangkat / Golongan</td><td>:</td><td>{{ $trip->pangkat }} / {{ $trip->golongan }}</td></tr>
    <tr><td></td><td>Jabatan</td><td>:</td><td>{{ $trip->jabatan }}</td></tr>
    <tr><td></td><td>Eselon</td><td>:</td><td>{{ ucwords(str_replace('_', ' ', $trip->eselon)) }}</td></tr>
    <tr><td>4.</td><td>Maksud</td><td>:</td><td>{{ $trip->maksud_perjalanan }}</td></tr>
    <tr><td>5.</td><td>Alat Angkutan</td><td>:</td><td>{{ strtoupper($trip->jenis_angkutan) }}</td></tr>
    <tr><td>6.</td><td>Tempat Berangkat</td><td>:</td><td>{{ $trip->tempat_keberangkatan }}</td></tr>
    <tr><td></td><td>Tujuan</td><td>:</td><td>{{ $trip->tujuan }}</td></tr>
    <tr><td>7.</td><td>Lama</td><td>:</td><td>{{ $trip->lama_hari }} hari</td></tr>
    <tr><td></td><td>Tgl Berangkat</td><td>:</td><td>{{ \Carbon\Carbon::parse($trip->tanggal_keberangkatan)->format('d F Y') }}</td></tr>
    <tr><td></td><td>Tgl Kembali</td><td>:</td><td>{{ \Carbon\Carbon::parse($trip->tanggal_kembali)->format('d F Y') }}</td></tr>
</table>

<br><br>

<table>
    <tr>
        <td width="50%">
            Pejabat Pembuat Komitmen<br><br>
            @if(file_exists($qrPath))
                <img src="{{ imageToBase64($qrPath) }}" width="80"><br>
            @endif
            (____________________)
        </td>
        <td width="50%" class="right">
            Jakarta, {{ \Carbon\Carbon::now()->format('d F Y') }}<br>
            Yang Bersangkutan<br><br><br>
            <b>{{ $trip->nama }}</b><br>
            NIP {{ $trip->nip }}
        </td>
    </tr>
</table>