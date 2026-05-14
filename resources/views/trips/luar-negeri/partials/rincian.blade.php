<div class="title text-center">
    RINCIAN BIAYA PERJALANAN DINAS
</div>

<table class="border">
    <thead>
        <tr>
            <th class="border">No</th>
            <th class="border">Uraian</th>
            <th class="border">Jumlah (USD)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="border text-center">1</td>
            <td class="border">Uang Harian ({{ $trip->lama_hari }} hari x USD {{ number_format($trip->uang_harian_per_hari, 2) }})</td>
            <td class="border text-right">USD {{ number_format($trip->total_uang_harian, 2) }}</td>
        </tr>
        <tr>
            <td class="border text-center">2</td>
            <td class="border">Transport Berangkat</td>
            <td class="border text-right">USD {{ number_format($trip->biaya_transport_berangkat, 2) }}</td>
        </tr>
        <tr>
            <td class="border text-center">3</td>
            <td class="border">Transport Pulang</td>
            <td class="border text-right">USD {{ number_format($trip->biaya_transport_pulang, 2) }}</td>
        </tr>
        <tr>
            <td class="border text-center">4</td>
            <td class="border">Hotel</td>
            <td class="border text-right">USD {{ number_format($trip->biaya_hotel, 2) }}</td>
        </tr>
        @if($trip->total_uang_representasi > 0)
        <tr>
            <td class="border text-center">5</td>
            <td class="border">Uang Representasi</td>
            <td class="border text-right">USD {{ number_format($trip->total_uang_representasi, 2) }}</td>
        </tr>
        @endif
        <tr>
            <td class="border"></td>
            <td class="border"><b>TOTAL</b></td>
            <td class="border text-right"><b>USD {{ number_format($trip->total_biaya, 2) }}</b></td>
        </tr>
    </tbody>
</table>

<br><br>

<table>
    <tr>
        <td width="60%"></td>
        <td class="text-center">
            Mengetahui,
            <br><br><br><br>
            <b>Bendahara Pengeluaran</b>
        </td>
    </tr>
</table>