<div class="judul">
    DAFTAR NOMINATIF PERJALANAN DINAS
</div>

<div class="center">
    {{ strtoupper($trip->maksud_perjalanan) }}
</div>

<br>

<table class="border">
    <tr>
        <th rowspan="2">NO.</th>
        <th rowspan="2">Nama / NIP</th>
        <th rowspan="2">Pangkat / Gol</th>
        <th rowspan="2">Tujuan</th>
        <th rowspan="2">Tgl. Perjalanan</th>
        <th rowspan="2">Lama Perjalanan</th>
        <th colspan="4">Biaya</th>
    </tr>
    <tr>
        <th>Transport</th>
        <th>Uang Harian</th>
        <th>Hotel</th>
        <th>Representatif</th>
    </tr>
    <tr>
        <td class="center">1</td>
        <td>{{ $trip->nama }}<br>NIP. {{ $trip->nip }}</td>
        <td>{{ $trip->pangkat }}<br>{{ $trip->golongan }}</td>
        <td>{{ $trip->tempat_keberangkatan }} - {{ $trip->tujuan }}</td>
        <td>{{ \Carbon\Carbon::parse($trip->tanggal_keberangkatan)->format('d F Y') }}</td>
        <td class="center">{{ $trip->lama_hari }} hari</td>
        <td class="right">{{ number_format(($trip->biaya_transport_berangkat ?? 0) + ($trip->biaya_transport_pulang ?? 0),0,',','.') }}</td>
        <td class="right">{{ number_format($trip->total_uang_harian,0,',','.') }}</td>
        <td class="right">{{ number_format($trip->biaya_hotel ?? 0,0,',','.') }}</td>
        <td class="right">{{ number_format($trip->total_uang_representasi ?? 0,0,',','.') }}</td>
    </tr>
</table>

<br><br>

<table class="no-border">
    <tr>
        <td width="60%"></td>
        <td class="center">
            Bendahara Pengeluaran
            <br><br><br><br><br>
            ___________________
        </td>
    </tr>
</table>