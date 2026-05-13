<div class="title text-center">
    RINCIAN BIAYA PERJALANAN DINAS
</div>

<table class="border">
    <thead>
        <tr>
            <th class="border">No</th>
            <th class="border">Uraian</th>
            <th class="border">Jumlah</th>
        </tr>
    </thead>

    <tbody>

        <tr>
            <td class="border text-center">1</td>
            <td class="border">Uang Harian</td>
            <td class="border">
                USD {{ number_format($trip->total_uang_harian, 2) }}
            </td>
        </tr>

        <tr>
            <td class="border text-center">2</td>
            <td class="border">Transport Berangkat</td>
            <td class="border">
                Rp {{ number_format($trip->biaya_transport_berangkat,0,',','.') }}
            </td>
        </tr>

        <tr>
            <td class="border text-center">3</td>
            <td class="border">Transport Pulang</td>
            <td class="border">
                Rp {{ number_format($trip->biaya_transport_pulang,0,',','.') }}
            </td>
        </tr>

        <tr>
            <td class="border text-center">4</td>
            <td class="border">Hotel</td>
            <td class="border">
                Rp {{ number_format($trip->biaya_hotel,0,',','.') }}
            </td>
        </tr>

        <tr>
            <td class="border"></td>

            <td class="border">
                <b>TOTAL</b>
            </td>

            <td class="border">
                <b>
                    Rp {{ number_format($trip->total_biaya,0,',','.') }}
                </b>
            </td>
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