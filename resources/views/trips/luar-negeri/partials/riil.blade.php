<div class="title text-center">
    DAFTAR PENGELUARAN RIIL
</div>

<table>
    <tr>
        <td width="30%">Nama</td>
        <td>: {{ $trip->nama }}</td>
    </tr>

    <tr>
        <td>NIP</td>
        <td>: {{ $trip->nip }}</td>
    </tr>

    <tr>
        <td>Tujuan</td>
        <td>: {{ $trip->tujuan }}</td>
    </tr>

    <tr>
        <td>Lama Perjalanan</td>
        <td>: {{ $trip->lama_hari }} Hari</td>
    </tr>
</table>

<br>

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
            <td class="border">
                Tiket Berangkat
            </td>
            <td class="border">
                Rp {{ number_format($trip->biaya_transport_berangkat,0,',','.') }}
            </td>
        </tr>

        <tr>
            <td class="border text-center">2</td>
            <td class="border">
                Tiket Pulang
            </td>
            <td class="border">
                Rp {{ number_format($trip->biaya_transport_pulang,0,',','.') }}
            </td>
        </tr>

        <tr>
            <td class="border text-center">3</td>
            <td class="border">
                Hotel/Penginapan
            </td>
            <td class="border">
                Rp {{ number_format($trip->biaya_hotel,0,',','.') }}
            </td>
        </tr>

        <tr>
            <td colspan="2" class="border">
                <b>TOTAL</b>
            </td>

            <td class="border">
                <b>
                    Rp {{
                        number_format(
                            $trip->biaya_transport_berangkat +
                            $trip->biaya_transport_pulang +
                            $trip->biaya_hotel,
                            0,
                            ',',
                            '.'
                        )
                    }}
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

            Yang Membuat Pernyataan,

            <br><br><br><br>

            <b>{{ $trip->nama }}</b>

        </td>
    </tr>
</table>