<div class="center">
    <b>RINCIAN BIAYA PERJALANAN DINAS</b>
</div>

<br>

<table class="border">
    <tr>
        <th width="5%">No</th>
        <th width="45%">Uraian</th>
        <th width="25%">Jumlah (Rp)</th>
        <th width="25%">Keterangan</th>
    </tr>
    <tr>
        <td class="center">1</td>
        <td>Uang Harian ({{ $trip->lama_hari }} hari x Rp {{ number_format($trip->uang_harian_per_hari, 0, ',', '.') }})</td>
        <td class="right">{{ number_format($trip->total_uang_harian, 0, ',', '.') }}</td>
        <td>{{ $trip->tujuan }}</td>
    </tr>
    @if($trip->total_uang_representasi > 0)
    <tr>
        <td class="center">2</td>
        <td>Uang Representasi ({{ $trip->lama_hari }} hari x Rp {{ number_format($trip->uang_representasi_per_hari, 0, ',', '.') }})</td>
        <td class="right">{{ number_format($trip->total_uang_representasi, 0, ',', '.') }}</td>
        <td>{{ str_replace('_', ' ', $trip->eselon) }}</td>
    </tr>
    @endif
    @if($trip->biaya_transport_berangkat > 0)
    <tr>
        <td class="center">{{ $trip->total_uang_representasi > 0 ? 3 : 2 }}</td>
        <td>Transport Berangkat</td>
        <td class="right">{{ number_format($trip->biaya_transport_berangkat, 0, ',', '.') }}</td>
        <td>{{ strtoupper($trip->jenis_angkutan) }}</td>
    </tr>
    @endif
    @if($trip->biaya_transport_pulang > 0)
    <tr>
        <td class="center">-</td>
        <td>Transport Pulang</td>
        <td class="right">{{ number_format($trip->biaya_transport_pulang, 0, ',', '.') }}</td>
        <td>{{ strtoupper($trip->jenis_angkutan) }}</td>
    </tr>
    @endif
    @if($trip->biaya_taxi_tujuan > 0)
    <tr>
        <td class="center">-</td>
        <td>Taxi di Kota Tujuan</td>
        <td class="right">{{ number_format($trip->biaya_taxi_tujuan, 0, ',', '.') }}</td>
        <td>{{ $trip->tujuan }}</td>
    </tr>
    @endif
    @if($trip->biaya_dalam_kota > 0)
    <tr>
        <td class="center">-</td>
        <td>Transport Dalam Kota</td>
        <td class="right">{{ number_format($trip->biaya_dalam_kota, 0, ',', '.') }}</td>
        <td>Jakarta</td>
    </tr>
    @endif
    @if($trip->biaya_transport_sekitar_jakarta > 0)
    <tr>
        <td class="center">-</td>
        <td>Transport Sekitar Jakarta</td>
        <td class="right">{{ number_format($trip->biaya_transport_sekitar_jakarta, 0, ',', '.') }}</td>
        <td>{{ $trip->tujuan }}</td>
    </tr>
    @endif
    @if($trip->biaya_hotel > 0)
    <tr>
        <td class="center">-</td>
        <td>Hotel/Penginapan</td>
        <td class="right">{{ number_format($trip->biaya_hotel, 0, ',', '.') }}</td>
        <td></td>
    </tr>
    @endif
    <tr style="font-weight:bold;">
        <td class="center" colspan="2">TOTAL</td>
        <td class="right">{{ number_format($trip->total_biaya, 0, ',', '.') }}</td>
        <td></td>
    </tr>
</table>

<br>

<table>
    <tr>
        <td width="50%">Menyetujui,<br>Pejabat Pembuat Komitmen<br><br><br><br>(____________________)</td>
        <td width="50%" class="right">Jakarta, {{ \Carbon\Carbon::now()->format('d F Y') }}<br>Yang Bersangkutan<br><br><br><br><b>{{ $trip->nama }}</b><br>NIP {{ $trip->nip }}</td>
    </tr>
</table>