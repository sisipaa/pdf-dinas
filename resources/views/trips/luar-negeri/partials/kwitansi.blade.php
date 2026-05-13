<div class="title text-center">
    KWITANSI PEMBAYARAN
</div>

<table>
    <tr>
        <td width="30%">Sudah Terima Dari</td>
        <td>: Kementerian Luar Negeri</td>
    </tr>

    <tr>
        <td>Untuk Pembayaran</td>
        <td>: Perjalanan Dinas Luar Negeri</td>
    </tr>

    <tr>
        <td>Nama</td>
        <td>: {{ $trip->nama }}</td>
    </tr>

    <tr>
        <td>Total Pembayaran</td>
        <td>
            : Rp {{ number_format($trip->total_biaya,0,',','.') }}
        </td>
    </tr>
</table>

<br><br>

<table>
    <tr>
        <td width="60%"></td>

        <td class="text-center">
            Yang Menerima,

            <br><br><br>

            @if(file_exists(public_path('qr.png')))
                <img src="{{ public_path('qr.png') }}" width="70">
            @endif

            <br>

            <b>{{ $trip->nama }}</b>
        </td>
    </tr>
</table>