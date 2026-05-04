<!-- PAGE BREAK -->
<div style="page-break-before: always;"></div>

<!-- HALAMAN: DAFTAR NOMINATIF PERJALANAN DINAS LUAR NEGERI -->
<div class="center">
    <h3>DAFTAR NOMINATIF PERJALANAN DINAS LUAR NEGERI</h3>
    <p style="font-size:11pt;">
        {{ $trip->maksud_perjalanan }}<br>
        Negara Tujuan: {{ $trip->tujuan }}
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
            <td class="label">Negara Tujuan</td>
            <td class="separator">:</td>
            <td>{{ $trip->tujuan }}</td>
        </tr>
        <tr>
            <td class="label">Golongan Uang Harian</td>
            <td class="separator">:</td>
            <td>{{ $trip->golongan_luar_negeri ?? '-' }} (A/B/C/D)</td>
        </tr>
    </table>
</div>

<div class="rincian-biaya">
    <table class="border">
        <thead>
            <tr>
                <th style="width:5%">No</th>
                <th style="width:18%">Nama</th>
                <th style="width:12%">NIP</th>
                <th style="width:12%">Jabatan</th>
                <th style="width:8%">Golongan</th>
                <th style="width:12%">Uang Harian</th>
                <th style="width:10%">Transport (USD)</th>
                <th style="width:10%">Hotel (USD)</th>
                <th style="width:13%">Total (USD)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="center">1</td>
                <td>{{ $trip->nama }}</td>
                <td>{{ $trip->nip }}</td>
                <td>{{ $trip->jabatan }}</td>
                <td class="center">{{ $trip->golongan_luar_negeri ?? '-' }}</td>
                <td class="right">
                    USD {{ number_format($trip->total_uang_harian,2,',','.') }}
                </td>
                <td class="right">
                    USD {{ number_format(
                        ($trip->biaya_transport_berangkat ?? 0) + 
                        ($trip->biaya_transport_pulang ?? 0), 2, ',', '.'
                    ) }}
                </td>
                <td class="right">
                    USD {{ number_format($trip->biaya_hotel ?? 0,2,',','.') }}
                </td>
                <td class="right">
                    USD {{ number_format($trip->total_biaya,2,',','.') }}
                </td>
            </tr>

            <!-- TOTAL ROW -->
            <tr style="background:#f2f2f2; font-weight:bold;">
                <td colspan="5" class="right">TOTAL</td>
                <td class="right">
                    USD {{ number_format($trip->total_uang_harian,2,',','.') }}
                </td>
                <td class="right">
                    USD {{ number_format(
                        ($trip->biaya_transport_berangkat ?? 0) + 
                        ($trip->biaya_transport_pulang ?? 0), 2, ',', '.'
                    ) }}
                </td>
                <td class="right">
                    USD {{ number_format($trip->biaya_hotel ?? 0,2,',','.') }}
                </td>
                <td class="right">
                    USD {{ number_format($trip->total_biaya,2,',','.') }}
                </td>
            </tr>
        </tbody>
    </table>

    <p class="terbilang" style="margin-top:15px;">
        Terbilang (USD): <strong>{{ ucfirst(app(\App\Http\Controllers\TripController::class)->terbilang($trip->total_biaya)) }} Dolar Amerika</strong>
    </p>
    <p class="terbilang">
        Terbilang (IDR - Kurs Rp15.000): <strong>{{ ucfirst(app(\App\Http\Controllers\TripController::class)->terbilang($trip->total_biaya * 15000)) }} Rupiah</strong>
    </p>
</div>

<!-- Tanda Tangan -->
<div class="tanda-tangan" style="margin-top:40px;">
    <table style="width:100%;">
        </tr>
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