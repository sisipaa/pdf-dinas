<div class="center"><b>DAFTAR PENGELUARAN RIIL</b></div>

<br>

Nama: {{ $trip->nama }}<br>
NIP: {{ $trip->nip }}<br>

<br>

<table class="border">
    <tr>
        <th>No</th><th>Uraian</th><th>Jumlah</th>
    </tr>
    <tr>
        <td>1</td>
        <td>Transport (Berangkat + Pulang)</td>
        <td class="right">Rp {{ number_format(($trip->biaya_transport_berangkat ?? 0) + ($trip->biaya_transport_pulang ?? 0),0,',','.') }}</td>
    </tr>
    <tr>
        <td>2</td>
        <td>Taxi (Jakarta + Tujuan)</td>
        <td class="right">Rp {{ number_format(($trip->biaya_taxi_jakarta ?? 0) + ($trip->biaya_taxi_tujuan ?? 0),0,',','.') }}</td>
    </tr>
    <tr>
        <td>3</td>
        <td>Hotel</td>
        <td class="right">Rp {{ number_format($trip->biaya_hotel,0,',','.') }}</td>
    </tr>
    <tr>
        <td colspan="2"><b>Total</b></td>
        <td class="right"><b>Rp {{ number_format($trip->total_biaya,0,',','.') }}</b></td>
    </tr>
</table>

<br><br>

<table>
    <tr>
        <td width="50%">
            Mengetahui<br><br><br><br>
            (____________)
        </td>
        <td width="50%" class="right">
            Yang membuat<br><br><br><br>
            {{ $trip->nama }}
        </td>
    </tr>
</table>