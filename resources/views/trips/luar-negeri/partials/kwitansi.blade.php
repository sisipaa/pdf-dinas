<div class="center"><b>KWITANSI PERJALANAN DINAS LUAR NEGERI</b></div>

<br>

Sudah terima dari: Pejabat Pembuat Komitmen<br>
Uang sebesar: <b>USD {{ number_format($trip->total_biaya,2,',','.') }}</b><br>
(Rp {{ number_format($trip->total_biaya * 15000,0,',','.') }} Rupiah)

<br><br>

Terbilang:
<b>{{ ucfirst(app(\App\Http\Controllers\TripController::class)->terbilang($trip->total_biaya * 15000)) }} Rupiah</b>

<br><br>

Untuk pembayaran perjalanan dinas luar negeri dari:
{{ $trip->tempat_keberangkatan }} (Indonesia) ke {{ $trip->tujuan }}

<br><br><br>

<table width="100%">
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