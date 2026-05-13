<div class="title text-center">
    LAPORAN PERJALANAN DINAS
</div>

<table>

    <tr>
        <td width="30%">Nama</td>
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
        <td>Negara Tujuan</td>
        <td>: {{ $trip->tujuan }}</td>
    </tr>

    <tr>
        <td>Tanggal Berangkat</td>
        <td>: {{ $trip->tanggal_keberangkatan }}</td>
    </tr>

    <tr>
        <td>Tanggal Kembali</td>
        <td>: {{ $trip->tanggal_kembali }}</td>
    </tr>

</table>

<br>

<table class="border">

    <tr>
        <td class="border" height="300">

            <b>HASIL PERJALANAN DINAS:</b>

            <br><br>

            {{ $trip->maksud_perjalanan }}

            <br><br><br>

            ....................................................................

            <br><br>

            ....................................................................

            <br><br>

            ....................................................................

        </td>
    </tr>

</table>

<br><br>

<table>

    <tr>

        <td width="60%"></td>

        <td class="text-center">

            Pelaksana Perjalanan Dinas

            <br><br><br><br>

            <b>{{ $trip->nama }}</b>

        </td>

    </tr>

</table>