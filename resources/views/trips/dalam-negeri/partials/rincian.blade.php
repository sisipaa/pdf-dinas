<div class="center"><b>RINCIAN BIAYA PERJALANAN DINAS</b></div>

<table class="border">
    <tr>
        <th>No</th><th>Uraian</th><th>Jumlah</th>
    </tr>
    <tr>
        <td>1</td>
        <td>Transport Berangkat</td>
        <td class="right">Rp {{ number_format($trip->biaya_transport_berangkat ?? 0,0,',','.') }}</td>
    </tr>
    <tr>
        <td>2</td>
        <td>Taxi Jakarta</td>
        <td class="right">Rp {{ number_format($trip->biaya_taxi_jakarta ?? 0,0,',','.') }}</td>
    </tr>
    <tr>
        <td>3</td>
        <td>Transport Pulang</td>
        <td class="right">Rp {{ number_format($trip->biaya_transport_pulang ?? 0,0,',','.') }}</td>
    </tr>
    <tr>
        <td>4</td>
        <td>Taxi Tujuan</td>
        <td class="right">Rp {{ number_format($trip->biaya_taxi_tujuan ?? 0,0,',','.') }}</td>
    </tr>
    <tr>
        <td>5</td>
        <td>Transport Dalam Kota Jakarta</td>
        <td class="right">Rp {{ number_format($trip->biaya_dalam_kota ?? 0,0,',','.') }}</td>
    </tr>
    <tr>
        <td>6</td>
        <td>Transport Sekitar Jakarta</td>
        <td class="right">Rp {{ number_format($trip->biaya_transport_sekitar_jakarta ?? 0,0,',','.') }}</td>
    </tr>
    <tr>
        <td>7</td>
        <td>Uang Harian ({{ $trip->lama_hari }} hari x Rp {{ number_format($trip->uang_harian_per_hari,0,',','.') }})</td>
        <td class="right">Rp {{ number_format($trip->total_uang_harian,0,',','.') }}</td>
    </tr>
    <tr>
        <td>8</td>
        <td>Uang Representasi ({{ $trip->lama_hari }} hari)</td>
        <td class="right">Rp {{ number_format($trip->total_uang_representasi ?? 0,0,',','.') }}</td>
    </tr>
    <tr>
        <td>9</td>
        <td>Biaya Hotel</td>
        <td class="right">Rp {{ number_format($trip->biaya_hotel,0,',','.') }}</td>
    </tr>
    <tr>
        <td colspan="2"><b>Total</b></td>
        <td class="right"><b>Rp {{ number_format($trip->total_biaya,0,',','.') }}</b></td>
    </tr>
</table>

<br>

Terbilang:
<b>{{ ucfirst(app(\App\Http\Controllers\TripController::class)->terbilang($trip->total_biaya)) }} Rupiah</b>