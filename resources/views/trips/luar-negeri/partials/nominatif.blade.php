<div class="title text-center">
    DAFTAR NOMINATIF PEMBAYARAN
</div>

<table class="border">

    <thead>
        <tr>
            <th class="border">No</th>
            <th class="border">Nama</th>
            <th class="border">NIP</th>
            <th class="border">Jabatan</th>
            <th class="border">Total</th>
        </tr>
    </thead>

    <tbody>

        <tr>
            <td class="border text-center">1</td>

            <td class="border">
                {{ $trip->nama }}
            </td>

            <td class="border">
                {{ $trip->nip }}
            </td>

            <td class="border">
                {{ $trip->jabatan }}
            </td>

            <td class="border">
                Rp {{ number_format($trip->total_biaya,0,',','.') }}
            </td>
        </tr>

    </tbody>

</table>

<br><br>

<table>
    <tr>

        <td width="60%"></td>

        <td class="text-center">

            Bendahara Pengeluaran

            <br><br><br><br>

            <b>___________________</b>

        </td>

    </tr>
</table>