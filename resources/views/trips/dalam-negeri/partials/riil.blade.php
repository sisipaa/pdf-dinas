<div class="judul">
    DAFTAR PENGELUARAN RIIL
</div>

<hr>

<br><br>

<table>
    <tr>
        <td width="20%">Nama</td>
        <td width="2%">:</td>
        <td>{{ $trip->nama }}</td>
    </tr>

    <tr>
        <td>NIP</td>
        <td>:</td>
        <td>{{ $trip->nip }}</td>
    </tr>

    <tr>
        <td>Pangkat/Gol</td>
        <td>:</td>
        <td>{{ $trip->pangkat }} {{ $trip->golongan }}</td>
    </tr>

    <tr>
        <td>Jabatan</td>
        <td>:</td>
        <td>{{ $trip->jabatan }}</td>
    </tr>
</table>

<br>

<table class="border">

    <tr>
        <th width="10%">No</th>
        <th>Uraian</th>
        <th width="30%">Jumlah</th>
    </tr>

    <tr>
        <td class="center">1</td>

        <td>
            Transport {{ ucfirst($trip->jenis_angkutan) }}
        </td>

        <td class="right">
            Rp.
            {{
                number_format(
                    ($trip->biaya_transport_berangkat ?? 0)
                    +
                    ($trip->biaya_transport_pulang ?? 0),
                    0,
                    ',',
                    '.'
                )
            }}
        </td>
    </tr>

    <tr>
        <td class="center">2</td>

        <td>Hotel / Penginapan</td>

        <td class="right">
            Rp.
            {{ number_format($trip->biaya_hotel ?? 0,0,',','.') }}
        </td>
    </tr>

    <tr>
        <td colspan="2" class="bold center">
            TOTAL
        </td>

        <td class="right bold">
            Rp.
            {{
                number_format(
                    (($trip->biaya_transport_berangkat ?? 0)
                    +
                    ($trip->biaya_transport_pulang ?? 0)
                    +
                    ($trip->biaya_hotel ?? 0)),
                    0,
                    ',',
                    '.'
                )
            }}
        </td>
    </tr>

</table>

<br><br><br>

<table class="no-border">
    <tr>
        <td width="60%"></td>

        <td class="center">
            Yang membuat pernyataan,

            <br><br><br><br><br>

            <b>{{ $trip->nama }}</b>
        </td>
    </tr>
</table>