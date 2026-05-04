<div class="center"><b>KWITANSI</b></div>

<br>

Sudah terima dari: Pejabat Pembuat Komitmen<br>
Uang sebesar: Rp {{ number_format($trip->total_biaya,0,',','.') }}<br>

Terbilang:
{{ ucfirst(app(\App\Http\Controllers\TripController::class)->terbilang($trip->total_biaya)) }} Rupiah

<br><br>

Untuk pembayaran perjalanan dinas dari:
{{ $trip->tempat_keberangkatan }} ke {{ $trip->tujuan }}

<br><br><br>

<table>
    <tr>
        <td width="50%">
            PPK<br><br><br><br>
            (____________________)
        </td>
        <td width="50%" class="right">
            Yang menerima<br><br><br><br>
            {{ $trip->nama }}
        </td>
    </tr>
</table>