<!-- PAGE BREAK -->
<div style="page-break-before: always;"></div>

<!-- HALAMAN: DAFTAR NOMINATIF PERJALANAN DINAS -->
<div class="center">
    <h3>DAFTAR NOMINATIF PERJALANAN DINAS</h3>
    <p style="font-size:11pt;">
        {{ $trip->maksud_perjalanan }}<br>
        Dalam Rangka Penguatan Manajemen
    </p>
</div>

<div class="isi-surat">
    <table style="margin-bottom:10px;">
        <tr>
            <td class="label" width="15%">Nomor Surat</td>
            <td class="separator" width="2%">:</td>
            <td>{{ $trip->nomor_surat ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal</td>
            <td class="separator">:</td>
            <td>{{ \Carbon\Carbon::parse($trip->tanggal_keberangkatan)->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td class="label">Kegiatan</td>
            <td class="separator">:</td>
            <td>{{ $trip->maksud_perjalanan }}</td>
        </tr>
        <tr>
            <td class="label">Lokasi</td>
            <td class="separator">:</td>
            <td>{{ $trip->tujuan }}</td>
        </tr>
    </table>
</div>

<div class="rincian-biaya">
    <table class="border">
        <thead>
            <tr>
                <th style="width:5%">No</th>
                <th style="width:20%">Nama</th>
                <th style="width:15%">NIP</th>
                <th style="width:15%">Jabatan</th>
                <th style="width:10%">Golongan</th>
                <th style="width:15%">Uang Harian</th>
                <th style="width:10%">Transport</th>
                <th style="width:10%">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="center">1</td>
                <td>{{ $trip->nama }}</td>
                <td>{{ $trip->nip }}</td>
                <td>{{ $trip->jabatan }}</td>
                <td>{{ $trip->golongan }}</td>
                <td class="right">
                    Rp {{ number_format($trip->total_uang_harian,0,',','.') }}
                </td>
                <td class="right">
                    Rp {{ number_format(
                        ($trip->biaya_transport_berangkat ?? 0) +
                        ($trip->biaya_taxi_jakarta ?? 0) +
                        ($trip->biaya_transport_pulang ?? 0) +
                        ($trip->biaya_taxi_tujuan ?? 0) +
                        ($trip->biaya_dalam_kota ?? 0) +
                        ($trip->biaya_transport_sekitar_jakarta ?? 0)
                    ,0,',','.') }}
                </td>
                <td class="right">
                    Rp {{ number_format($trip->total_biaya,0,',','.') }}
                </td>
            </tr>

            <!-- TOTAL ROW -->
            <tr style="background:#f2f2f2; font-weight:bold;">
                <td colspan="6" class="right">TOTAL</td>
                <td class="right">
                    Rp {{ number_format(
                        ($trip->biaya_transport_berangkat ?? 0) +
                        ($trip->biaya_taxi_jakarta ?? 0) +
                        ($trip->biaya_transport_pulang ?? 0) +
                        ($trip->biaya_taxi_tujuan ?? 0) +
                        ($trip->biaya_dalam_kota ?? 0) +
                        ($trip->biaya_transport_sekitar_jakarta ?? 0)
                    ,0,',','.') }}
                </td>
                <td class="right">
                    Rp {{ number_format($trip->total_biaya,0,',','.') }}
                </td>
            </tr>
        </tbody>
    </table>

    <p class="terbilang" style="margin-top:15px;">
        Terbilang: <strong>{{ ucfirst(app(\App\Http\Controllers\TripController::class)->terbilang($trip->total_biaya)) }} Rupiah</strong>
    </p>
</div>

<!-- Tanda Tangan -->
<div class="tanda-tangan" style="margin-top:40px;">
    <table style="width:100%;">
        <tr>
            <td width="60%"></td>
            <td width="40%" class="center">
                Jakarta, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                Pejabat Pembuat Komitmen<br><br>

                @if(file_exists(public_path('qr.png')))
                    <img src="{{ public_path('qr.png') }}" width="80"><br>
                @endif

                (____________________)
            </td>
        </tr>
    </table>
</div>