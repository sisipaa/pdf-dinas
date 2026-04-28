<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Perjalanan Dinas Dalam Negeri</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            padding: 15mm 20mm;
        }

        /* Kop Surat */
        .kop-surat {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        .kop-surat h1 {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
            line-height: 1.3;
        }

        .kop-surat h2 {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 3px 0;
            line-height: 1.3;
        }

        .kop-surat .alamat {
            font-size: 10pt;
            margin: 3px 0;
        }

        .kop-surat .kontak {
            font-size: 9pt;
            margin: 2px 0;
        }

        /* Judul Surat */
        .judul-surat {
            text-align: center;
            margin: 15px 0;
        }

        .judul-surat h3 {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            margin: 0;
        }

        .judul-surat .nomor-surat {
            font-size: 11pt;
            margin: 3px 0;
        }

        /* Isi Surat - Tabel Data */
        .isi-surat {
            margin: 15px 0;
        }

        .isi-surat table {
            width: 100%;
            border-collapse: collapse;
        }

        .isi-surat table td {
            padding: 3px 0;
            vertical-align: top;
            font-size: 11pt;
        }

        .isi-surat table td.label {
            width: 200px;
        }

        .isi-surat table td.separator {
            width: 10px;
            text-align: center;
        }

        /* Rincian Biaya */
        .rincian-biaya {
            margin-top: 20px;
        }

        .rincian-biaya h4 {
            font-size: 12pt;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            margin-bottom: 8px;
            text-align: center;
        }

        .rincian-biaya table {
            width: 100%;
            border-collapse: collapse;
        }

        .rincian-biaya table th,
        .rincian-biaya table td {
            border: 1px solid #000;
            padding: 5px 6px;
            font-size: 10pt;
        }

        .rincian-biaya table th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }

        .rincian-biaya table td.text-center {
            text-align: center;
        }

        .rincian-biaya table td.text-right {
            text-align: right;
        }

        .rincian-biaya table td.text-left {
            text-align: left;
        }

        .total-row {
            font-weight: bold;
            background-color: #f5f5f5;
        }

        .terbilang {
            margin-top: 8px;
            font-style: italic;
            font-size: 10pt;
        }

        /* Tanda Tangan */
        .tanda-tangan {
            margin-top: 25px;
            width: 100%;
        }

        .tanda-tangan table {
            width: 100%;
            border: none;
        }

        .tanda-tangan table td {
            border: none;
            vertical-align: top;
            padding: 5px;
            font-size: 11pt;
        }

        .tanda-tangan .ppk {
            text-align: left;
        }

        .tanda-tangan .pegawai {
            text-align: right;
        }

        .tanda-tangan .ppk p,
        .tanda-tangan .pegawai p {
            margin: 3px 0;
        }

        .signature-box {
            margin-top: 60px;
            text-align: center;
        }

        .signature-box .nama {
            font-weight: bold;
            text-decoration: underline;
        }

        .signature-box .nip {
            margin-top: 3px;
        }

        /* Footer */
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 9pt;
            font-style: italic;
            color: #333;
            border-top: 1px solid #ccc;
            padding-top: 8px;
        }

        .footer p {
            margin: 2px 0;
        }

        /* Page break avoidance */
        .no-break {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
    <!-- Kop Surat -->
    <div class="kop-surat">
        <h1>KEMENTERIAN/LEMBAGA INSTANSI</h1>
        <h2>DIREKTORAT JENDERAL ADMINISTRASI</h2>
        <p class="alamat">Jl. Jenderal Sudirman Kav. 1-2, Jakarta Pusat</p>
        <p class="kontak">Telepon: (021) 1234567 | Email: info@instansi.go.id</p>
    </div>

    <!-- Judul Surat -->
    <div class="judul-surat">
        <h3>SURAT PERJALANAN DINAS DALAM NEGERI</h3>
        <p class="nomor-surat">Nomor: {{ $trip->nomor_surat ?? '........../........../........' }}</p>
    </div>

    <!-- Isi Surat -->
    <div class="isi-surat no-break">
        <table>
            <tr>
                <td class="label">Nama</td>
                <td class="separator">:</td>
                <td>{{ $trip->nama }}</td>
            </tr>
            <tr>
                <td class="label">NIP</td>
                <td class="separator">:</td>
                <td>{{ $trip->nip }}</td>
            </tr>
            <tr>
                <td class="label">Pangkat/Golongan</td>
                <td class="separator">:</td>
                <td>{{ $trip->pangkat }} / {{ $trip->golongan }}</td>
            </tr>
            <tr>
                <td class="label">Jabatan</td>
                <td class="separator">:</td>
                <td>{{ $trip->jabatan }}</td>
            </tr>
            <tr>
                <td class="label">Maksud Perjalanan</td>
                <td class="separator">:</td>
                <td>{{ $trip->maksud_perjalanan }}</td>
            </tr>
            <tr>
                <td class="label">Jenis Angkutan</td>
                <td class="separator">:</td>
                <td>{{ strtoupper($trip->jenis_angkutan) }}</td>
            </tr>
            <tr>
                <td class="label">Tempat Keberangkatan</td>
                <td class="separator">:</td>
                <td>{{ $trip->tempat_keberangkatan }}</td>
            </tr>
            <tr>
                <td class="label">Tempat Tujuan</td>
                <td class="separator">:</td>
                <td>{{ $trip->tujuan }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Keberangkatan</td>
                <td class="separator">:</td>
                <td>{{ \Carbon\Carbon::parse($trip->tanggal_keberangkatan)->locale('id')->isoFormat('D MMMM Y') }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Kembali</td>
                <td class="separator">:</td>
                <td>{{ \Carbon\Carbon::parse($trip->tanggal_kembali)->locale('id')->isoFormat('D MMMM Y') }}</td>
            </tr>
            <tr>
                <td class="label">Lama Hari</td>
                <td class="separator">:</td>
                <td>{{ $trip->lama_hari }} ({{ $trip->lama_hari }} hari)</td>
            </tr>
        </table>
    </div>

    <!-- Rincian Biaya -->
    <div class="rincian-biaya no-break">
        <h4>RINCIAN BIAYA PERJALANAN DINAS</h4>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 45%;">Uraian</th>
                    <th style="width: 15%;">Volume</th>
                    <th style="width: 15%;">Satuan</th>
                    <th style="width: 20%;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1</td>
                    <td class="text-left">Uang Harian</td>
                    <td class="text-center">{{ $trip->lama_hari }}</td>
                    <td class="text-center">Hari</td>
                    <td class="text-right">Rp {{ number_format($trip->total_uang_harian, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="text-center">2</td>
                    <td class="text-left">Biaya Transport ({{ $trip->jenis_transport ?? '-' }})</td>
                    <td class="text-center">1</td>
                    <td class="text-center">Paket</td>
                    <td class="text-right">Rp {{ number_format($trip->biaya_transport ?? 0, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="text-center">3</td>
                    <td class="text-left">Biaya Hotel</td>
                    <td class="text-center">1</td>
                    <td class="text-center">Paket</td>
                    <td class="text-right">Rp {{ number_format($trip->biaya_hotel ?? 0, 0, ',', '.') }}</td>
                </tr>
                <tr class="total-row">
                    <td class="text-center">4</td>
                    <td class="text-left" colspan="3">TOTAL BIAYA</td>
                    <td class="text-right">Rp {{ number_format($trip->total_biaya, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
        <p class="terbilang">
            Terbilang: <strong>{{ ucfirst($this->terbilang($trip->total_biaya)) }} Rupiah</strong>
        </p>
    </div>

    <!-- Tanda Tangan -->
    <div class="tanda-tangan no-break">
        <table>
            <tr>
                <td class="ppk" width="50%">
                    <p>Pejabat Pembuat Komitmen,</p>
                    <div class="signature-box">
                        <p class="nama">________________________</p>
                        <p class="nip">NIP. ........................</p>
                    </div>
                </td>
                <td class="pegawai" width="50%">
                    <p>Jakarta, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}</p>
                    <p>Yang Bersangkutan,</p>
                    <div class="signature-box">
                        <p class="nama">{{ $trip->nama }}</p>
                        <p class="nip">NIP. {{ $trip->nip }}</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini dibuat secara elektronik dan sah tanpa tanda tangan basah.</p>
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y HH:mm') }} WIB</p>
    </div>
</body>
</html>
