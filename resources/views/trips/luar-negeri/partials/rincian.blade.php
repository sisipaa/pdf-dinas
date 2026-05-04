<div class="center"><b>RINCIAN BIAYA PERJALANAN DINAS LUAR NEGERI</b></div>
<div class="center">Mata Uang: USD (Dolar Amerika)</div>

<br>

<table class="border">
    <tr>
        <th>No</th><th>Uraian</th><th>Jumlah (USD)</th>
    </tr>
    <tr>
        <td>1</td><td>Transport Berangkat (Pesawat)</td>
        <td class="right">USD {{ number_format($trip->biaya_transport_berangkat ?? 0,2,',','.') }}</td>
    </tr>
    <tr>
        <td>2</td><td>Transport Pulang (Pesawat)</td>
        <td class="right">USD {{ number_format($trip->biaya_transport_pulang ?? 0,2,',','.') }}</td>
    </tr>
    <tr>
        <td>3</td><td>Uang Harian ({{ $trip->lama_hari }} hari x USD {{ number_format($trip->uang_harian_per_hari,2,',','.') }})</td>
        <td class="right">USD {{ number_format($trip->total_uang_harian,2,',','.') }}</td>
    </tr>
    <tr>
        <td>4</td><td>Uang Representasi ({{ $trip->lama_hari }} hari)</td>
        <td class="right">Rp {{ number_format($trip->total_uang_representasi ?? 0,0,',','.') }}</td>
    </tr>
    <tr>
        <td>5</td><td>Biaya Hotel (Penginapan)</td>
        <td class="right">USD {{ number_format($trip->biaya_hotel,2,',','.') }}</td>
    </tr>
    <tr style="background:#f2f2f2;">
        <td colspan="2"><b>SUB TOTAL (USD)</b></td>
        <td class="right"><b>USD {{ number_format(
            ($trip->biaya_transport_berangkat ?? 0) + 
            ($trip->biaya_transport_pulang ?? 0) + 
            $trip->total_uang_harian + 
            $trip->biaya_hotel, 2, ',', '.'
        ) }}</b></td>
    </tr>
    <tr>
        <td colspan="2"><b>GRAND TOTAL (USD) + Representasi</b></td>
        <td class="right"><b>USD {{ number_format($trip->total_biaya,2,',','.') }}</b></td>
    </tr>
    <tr>
        <td colspan="2"><b>Konversi ke IDR (Kurs Rp15.000/USD)</b></td>
        <td class="right"><b>Rp {{ number_format($trip->total_biaya * 15000,0,',','.') }}</b></td>
    </tr>
</table>

<br>

Terbilang (USD):
<b>{{ ucfirst(app(\App\Http\Controllers\TripController::class)->terbilang($trip->total_biaya)) }} Dolar Amerika</b>

<br><br>

Terbilang (IDR):
<b>{{ ucfirst(app(\App\Http\Controllers\TripController::class)->terbilang($trip->total_biaya * 15000)) }} Rupiah</b>