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
        <td>Nama / NIP Pegawai yang melaksanakan perjalanan dinas</td>
        <td>{{ $trip->nama }} / {{ $trip->nip }}</td>
    </tr>

    <tr>
        <td class="center">3.</td>
        <td>
</table>