<div class="judul">
    RINCIAN BIAYA PERJALANAN DINAS
</div>

<br>

<table class="border">
    <tr>
        <th width="5%">No.</th>
        <th>Perincian Biaya</th>
        <th width="25%">Jumlah</th>
        <th width="20%">Keterangan</th>
    </tr>

    <tr>
        <td class="center">1</td>
        <td>Angkutan dari tempat kedudukan ke tempat tujuan</td>
        <td class="right">
            Rp. {{ number_format(($trip->biaya_transport_berangkat ?? 0) + ($trip->biaya_transport_pulang ?? 0),0,',','.') }}
        </td>
        <td>{{ ucfirst($trip->jenis_angkutan) }}</td>
    </tr>

    <tr>
        <td class="center">2</td>
        <td>
            Uang Harian :
            {{ $trip->lama_hari }} hari x
            Rp {{ number_format($trip->uang_harian_per_hari,0,',','.') }}
        </td>

        <td class="right">
            Rp. {{ number_format($trip->total_uang_harian,0,',','.') }}
        </td>

        <td></td>
    </tr>

    <tr>
        <td class="center">3</td>
        <td>
            Hotel :
            {{ $trip->lama_hari }} malam x
            Rp {{ number_format($trip->biaya_hotel,0,',','.') }}
        </td>

        <td class="right">
            Rp. {{ number_format($trip->biaya_hotel,0,',','.') }}
        </td>

        <td></td>
    </tr>

    @if($trip->total_uang_representasi > 0)
    <tr>
        <td class="center">4</td>
        <td>
            Representatif :
            {{ $trip->lama_hari }} hari x
            Rp {{ number_format($trip->uang_representasi_per_hari,0,',','.') }}
        </td>

        <td class="right">
            Rp. {{ number_format($trip->total_uang_representasi,0,',','.') }}
        </td>

        <td></td>
</table>