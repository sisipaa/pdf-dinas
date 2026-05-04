<div class="center"><b>DAFTAR PENGELUARAN RIIL PERJALANAN DINAS LUAR NEGERI</b></div>

<br>

Nama: {{ $trip->nama }}<br>
NIP: {{ $trip->nip }}<br>
Negara Tujuan: {{ $trip->tujuan }}<br>

<br>

<table class="border">
    <tr>
        <th>No</th><th>Uraian</th><th>Jumlah</th>
    </tr>
    <tr>
        <td>1</td><td>Transport (Berangkat + Pulang)</td>
        <td class="right">USD {{ number_format(($trip->biaya_transport_berangkat ?? 0) + ($trip->biaya_transport_pulang ?? 0),2,',','.') }}</td>
    </tr>
    <tr>
        <td>2</td><td>Uang Harian ({{ $trip->lama_hari }} hari)</td>
        <td class="right">USD {{ number_format($trip->total_uang_harian,2,',','.') }}</td>
    </tr>
    <tr>
        <td>3</td><td>Uang Representasi</td>
        <td class="right">Rp {{ number_format($trip->total_uang_representasi ?? 0,0,',','.') }}</td>
    </tr>
    <tr>
        <td>4</td><td>Hotel</td>
        <td class="right">USD {{ number_format($trip->biaya_hotel,2,',','.') }}</td>
    </tr>
    <tr style="background:#f2f2f2;">
        <td colspan="2"><b>TOTAL (USD)</b></td>
        <td class="right"><b>USD {{ number_format($trip->total_biaya,2,',','.') }}</b></td>
    </tr>
    <tr>
        <td colspan="2"><b>TOTAL (IDR - Kurs Rp15.000)</b></td>
        <td class="right"><b>Rp {{ number_format($trip->total_biaya * 15000,0,',','.') }}</b></td>
    </tr>
</table>

<br><br>

<table width="100%">
    <tr>
        <td width="50%">
            Mengetahui<br><br><br><br>
            (____________________)
        </td>
        <td width="50%" class="right">
            Yang membuat<br><br><br><br>
            {{ $trip->nama }}
        </td>
    </table>
</table>