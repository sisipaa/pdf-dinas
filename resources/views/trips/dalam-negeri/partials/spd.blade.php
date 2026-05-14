<div class="center small">
    Lembar ke : I/II/III/IV
</div>

<table class="no-border">
    <tr>
        <td width="20%">
            @php
                $logoPath = public_path('logo.png');
            @endphp

            @if(file_exists($logoPath))
                <img src="{{ imageToBase64($logoPath) }}" width="70">
            @endif
        </td>

        <td class="center">
            <b>BADAN KARANTINA INDONESIA</b><br>
            Jl. Harsono RM No. 3, Jakarta Selatan
        </td>

        <td width="25%">
            Kode No. :<br>
            Nomor : {{ $trip->nomor_surat ?? '-' }}
        </td>
    </tr>
</table>

<br>

<div class="judul">
    SURAT PERJALANAN DINAS<br>
    (SPD)
</div>

<br>

<table class="border">
    <tr>
        <td width="5%" class="center">1.</td>
        <td width="35%">Pejabat Pembuat Komitmen</td>
        <td>DEPUTI BIDANG KARANTINA HEWAN</td>
    </tr>
    <tr>
        <td class="center">2.</td>
        <td>Nama / NIP</td>
        <td>{{ $trip->nama }} / {{ $trip->nip }}</td>
    </tr>
    <tr>
        <td class="center">3.</td>
        <td>Pangkat / Golongan</td>
        <td>{{ $trip->pangkat }} / {{ $trip->golongan }}</td>
    </tr>
    <tr>
        <td class="center">4.</td>
        <td>Jabatan</td>
        <td>{{ $trip->jabatan }}</td>
    </tr>
    <tr>
        <td class="center">5.</td>
        <td>Maksud Perjalanan Dinas</td>
        <td>{{ $trip->maksud_perjalanan }}</td>
    </tr>
    <tr>
        <td class="center">6.</td>
        <td>Tempat Tujuan</td>
        <td>{{ $trip->tujuan }}</td>
    </tr>
    <tr>
        <td class="center">7.</td>
        <td>Lama Perjalanan</td>
        <td>{{ $trip->lama_hari }} Hari</td>
    </tr>
    <tr>
        <td class="center">8.</td>
        <td>Tanggal Berangkat</td>
        <td>{{ \Carbon\Carbon::parse($trip->tanggal_keberangkatan)->format('d F Y') }}</td>
    </tr>
    <tr>
        <td class="center">9.</td>
        <td>Tanggal Kembali</td>
        <td>{{ \Carbon\Carbon::parse($trip->tanggal_kembali)->format('d F Y') }}</td>
    </tr>
</table>

<br><br>

<table class="no-border">
    <tr>
        <td width="60%"></td>
        <td class="center">
            Jakarta, {{ \Carbon\Carbon::parse($trip->tanggal_keberangkatan)->format('d F Y') }}
            <br><br><br><br>
            <b>Pejabat Pembuat Komitmen</b>
        </td>
    </tr>
</table>