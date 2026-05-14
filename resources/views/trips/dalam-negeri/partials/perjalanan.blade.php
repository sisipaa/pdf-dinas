<table class="border">
    <tr>
        <td width="50%">
            <b>I. Berangkat dari :</b> {{ $trip->tempat_keberangkatan }}<br>
            (Tempat Kedudukan)<br>
            Ke : {{ $trip->tujuan }}<br>
            Pada tanggal : {{ \Carbon\Carbon::parse($trip->tanggal_keberangkatan)->format('d F Y') }}
            <br><br><br>
            Deputi Bidang Karantina Hewan
            <br><br><br>
            {{ $trip->nama }}<br>
            NIP {{ $trip->nip }}
        </td>
        <td width="50%">
            <b>II. Tiba di :</b> {{ $trip->tujuan }}<br>
            Pada tanggal : {{ \Carbon\Carbon::parse($trip->tanggal_keberangkatan)->format('d F Y') }}
            <br>
            Kepala :
            <br><br><br>
            Berangkat dari : {{ $trip->tujuan }}<br>
            ke : {{ $trip->tempat_keberangkatan }}<br>
            Pada tanggal : {{ \Carbon\Carbon::parse($trip->tanggal_kembali)->format('d F Y') }}
            <br>
            Kepala :
        </td>
    </tr>
    <tr>
        <td>
            <b>III. Tiba di :</b><br><br><br>
            Pada tanggal :
            <br><br><br>
            Kepala :
        </td>
        <td>
            <b>IV. Berangkat dari :</b><br><br><br>
        </td>
    </tr>
</table>