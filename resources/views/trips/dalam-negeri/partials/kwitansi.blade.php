<table>
    <tr>
        <td width="33%">
            NBK :<br>
            TGL : ..........<br>
            MAK :
        </td>

        <td class="center">
            <b>BADAN KARANTINA INDONESIA</b><br>
            JL. Harsono RM No. 3, Ragunan<br>
            JAKARTA SELATAN
        </td>

        <td width="20%">
            Tahun : {{ now()->format('Y') }}
        </td>
    </tr>
</table>

<hr>

<div class="judul">
    K W I T A N S I
</div>

<br>

<table>
    <tr>
        <td width="30%">Sudah terima dari</td>
        <td width="2%">:</td>
        <td>Pejabat Pembuat Komitmen Deputi Bidang Karantina Hewan</td>
    </tr>

    <tr>
        <td>Uang sebesar</td>
        <td>:</td>
        <td><b>Rp. {{ number_format($trip->total_biaya,0,',','.') }},-</b></td>
    </tr>

    <tr>
        <td>Terbilang</td>
        <td>:</td>
        <td>
            <b>
                ({{ ucfirst(app(\App\Http\Controllers\TripController::class)->terbilang($trip->total_biaya)) }} Rupiah)
            </b>
        </td>
    </tr>

    <tr>
        <td>Guna pembayaran</td>
        <td>:</td>
        <td>
            ongkos perjalanan dinas menurut Surat Perintah Perjalanan Dinas dari Pejabat Pembuat Komitmen Deputi Bidang Karantina Hewan
        </td>
    </tr>
</table>

<br><br>

<table class="no-border">
    <tr>
        <td width="60%"></td>

        <td class="center">
            Yang Menerima,

            <br><br><br><br><br>

            <b>{{ $trip->nama }}</b>
        </td>
    </tr>
</table>