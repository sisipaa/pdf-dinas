@extends('layouts.app')

@section('title', 'Input Perjalanan Dinas Luar Negeri')

@section('content')
<div style="max-width:900px; margin:auto; background:#fff; padding:20px; border-radius:8px;">

    <h2 style="text-align:center; margin-bottom:20px;">🌏 Form Perjalanan Dinas Luar Negeri</h2>

    <form action="{{ route('trips.luar-negeri.store') }}" method="POST">
        @csrf

        <!-- DATA PEGAWAI -->
        <fieldset style="border:1px solid #ddd; padding:15px; margin-bottom:20px; border-radius:5px;">
            <legend style="font-weight:bold;">📋 Data Pegawai</legend>

            <div style="margin-bottom:10px;">
                <label>Nama Lengkap</label><br>
                <input type="text" name="nama" required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
            </div>

            <div style="margin-bottom:10px;">
                <label>NIP</label><br>
                <input type="text" name="nip" required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
            </div>

            <div style="margin-bottom:10px;">
                <label>Pangkat</label><br>
                <input type="text" name="pangkat" required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
            </div>

            <div style="margin-bottom:10px;">
                <label>Golongan (Contoh: IV/a, III/b, dll)</label><br>
                <input type="text" name="golongan" required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
            </div>

            <div style="margin-bottom:10px;">
                <label>Jabatan</label><br>
                <input type="text" name="jabatan" required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
            </div>

            <div style="margin-bottom:10px;">
                <label>Eselon</label><br>
                <select name="eselon" required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                    <option value="pejabat_negara">🏛️ Pejabat Negara/Wakil Menteri (Rp250.000/hari)</option>
                    <option value="eselon_i">⭐ Eselon I (Rp200.000/hari)</option>
                    <option value="eselon_ii">⭐⭐ Eselon II (Rp150.000/hari)</option>
                    <option value="eselon_iii">⭐⭐⭐ Eselon III ke bawah (Rp0/hari)</option>
                </select>
                <small style="color:#666;">*Mempengaruhi uang representasi</small>
            </div>
        </fieldset>

        <!-- DATA PERJALANAN -->
        <fieldset style="border:1px solid #ddd; padding:15px; margin-bottom:20px; border-radius:5px;">
            <legend style="font-weight:bold;">✈️ Data Perjalanan Luar Negeri</legend>

            <div style="margin-bottom:10px;">
                <label>Nomor Surat (Opsional)</label><br>
                <input type="text" name="nomor_surat" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
            </div>

            <div style="margin-bottom:10px;">
                <label>Maksud Perjalanan</label><br>
                <textarea name="maksud_perjalanan" rows="3" required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"></textarea>
            </div>

            <div style="margin-bottom:10px;">
                <label>Jenis Angkutan</label><br>
                <select name="jenis_angkutan" required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                    <option value="darat">🚗 Darat</option>
                    <option value="udara">✈️ Udara</option>
                    <option value="laut">🚢 Laut</option>
                </select>
            </div>

            <div style="margin-bottom:10px;">
                <label>Tempat Keberangkatan (Kota Asal)</label><br>
                <input type="text" name="tempat_keberangkatan" required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
            </div>

            <div style="margin-bottom:10px;">
                <label>🌍 Negara Tujuan</label><br>
                <select name="tujuan" id="tujuan" required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                    <option value="">Pilih Negara Tujuan</option>
                    @foreach($negaraOptions as $negara)
                        <option value="{{ $negara }}">{{ $negara }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom:10px;">
                <label>🎖️ Golongan Uang Harian Luar Negeri</label><br>
                <select name="golongan_luar_negeri" id="golongan" required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                    <option value="A">Golongan A (Tertinggi) - Pejabat Negara/Eselon I</option>
                    <option value="B">Golongan B - Eselon II</option>
                    <option value="C">Golongan C - Eselon III</option>
                    <option value="D">Golongan D (Terendah) - Eselon IV/Staf</option>
                </select>
                <small style="color:#666;">*Sesuai dengan golongan pejabat dan negara tujuan</small>
            </div>

            <div style="margin-bottom:10px;">
                <label>📅 Tanggal Keberangkatan</label><br>
                <input type="date" name="tanggal_keberangkatan" id="tanggal_berangkat" required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
            </div>

            <div style="margin-bottom:10px;">
                <label>📅 Tanggal Kembali</label><br>
                <input type="date" name="tanggal_kembali" id="tanggal_kembali" required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
            </div>

            <div style="margin-bottom:10px;">
                <label>📊 Lama Hari (Otomatis)</label><br>
                <input type="number" name="lama_hari" id="lama_hari" readonly style="width:100%; padding:8px; background:#f0f0f0; border:1px solid #ccc; border-radius:4px;">
            </div>
        </fieldset>

        <!-- BIAYA LUAR NEGERI -->
        <fieldset style="border:1px solid #ddd; padding:15px; margin-bottom:20px; border-radius:5px;">
            <legend style="font-weight:bold;">💰 Biaya Perjalanan (USD - Dolar Amerika)</legend>

            <div style="margin-bottom:10px;">
                <label>✈️ Biaya Transport Berangkat (Tiket Pesawat)</label><br>
                <input type="number" name="biaya_transport_berangkat" value="0" step="100" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                <small>Dalam USD (Dolar Amerika)</small>
            </div>

            <div style="margin-bottom:10px;">
                <label>✈️ Biaya Transport Pulang (Tiket Pesawat)</label><br>
                <input type="number" name="biaya_transport_pulang" value="0" step="100" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                <small>Dalam USD (Dolar Amerika)</small>
            </div>

            <div style="margin-bottom:10px;">
                <label>🏨 Biaya Hotel (Penginapan per malam)</label><br>
                <input type="number" name="biaya_hotel" value="0" step="50" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                <small>Dalam USD (Dolar Amerika)</small>
            </div>
        </fieldset>

        <!-- RINGKASAN -->
        <div style="background:#e8f4f8; padding:15px; border-radius:5px; margin-bottom:20px;">
            <h4>📊 Ringkasan Otomatis:</h4>
            <p>💰 <strong>Uang Harian per hari:</strong> <span id="uang_harian_per_hari">-</span> USD</p>
            <p>🎖️ <strong>Uang Representasi per hari:</strong> <span id="uang_representasi_per_hari">-</span> IDR</p>
            <p>💵 <strong>Total Uang Harian ({{ $trip->lama_hari ?? '?' }} hari):</strong> <span id="total_uang_harian">-</span> USD</p>
            <p>📊 <strong>Total Perkiraan Biaya Keseluruhan:</strong> <span id="total_estimasi">-</span> USD</p>
        </div>

        <button type="submit" style="background:#28a745; color:#fff; padding:12px 24px; border:none; border-radius:5px; cursor:pointer; font-size:16px; font-weight:bold;">
            💾 Simpan & Generate PDF
        </button>
    </form>
</div>

<script>
    // Hitung lama hari otomatis
    const tglBerangkat = document.getElementById('tanggal_berangkat');
    const tglKembali = document.getElementById('tanggal_kembali');
    const lamaHari = document.getElementById('lama_hari');

    function hitungLamaHari() {
        if (tglBerangkat.value && tglKembali.value) {
            const start = new Date(tglBerangkat.value);
            const end = new Date(tglKembali.value);
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            lamaHari.value = diffDays;
            hitungTotal();
        }
    }

    tglBerangkat.addEventListener('change', hitungLamaHari);
    tglKembali.addEventListener('change', hitungLamaHari);

    // Data dari config
    const uangHarianData = @json(config('uang-harian.luar_negeri'));
    const representasiData = {
        'pejabat_negara': 250000,
        'eselon_i': 200000,
        'eselon_ii': 150000,
        'eselon_iii': 0
    };

    // Elemen DOM
    const tujuanSelect = document.getElementById('tujuan');
    const golonganSelect = document.getElementById('golongan');
    const eselonSelect = document.querySelector('select[name="eselon"]');
    const uangHarianSpan = document.getElementById('uang_harian_per_hari');
    const representasiSpan = document.getElementById('uang_representasi_per_hari');
    const totalUangHarianSpan = document.getElementById('total_uang_harian');
    const totalEstimasiSpan = document.getElementById('total_estimasi');

    // Update uang harian
    function updateUangHarian() {
        const negara = tujuanSelect.value;
        const golongan = golonganSelect.value;
        
        if (negara && uangHarianData[negara]) {
            const nilai = uangHarianData[negara];
            if (typeof nilai === 'object') {
                const uangHarian = nilai[golongan] || nilai['A'] || 0;
                uangHarianSpan.innerText = uangHarian.toLocaleString('id-ID');
            } else {
                uangHarianSpan.innerText = nilai.toLocaleString('id-ID');
            }
        } else {
            uangHarianSpan.innerText = '-';
        }
        hitungTotal();
    }

    // Update representasi
    function updateRepresentasi() {
        const eselon = eselonSelect.value;
        representasiSpan.innerText = (representasiData[eselon] || 0).toLocaleString('id-ID');
        hitungTotal();
    }

    // Hitung total
    function hitungTotal() {
        const negara = tujuanSelect.value;
        const golongan = golonganSelect.value;
        const hari = parseInt(lamaHari.value) || 0;
        
        let uangHarian = 0;
        if (negara && uangHarianData[negara]) {
            const nilai = uangHarianData[negara];
            if (typeof nilai === 'object') {
                uangHarian = nilai[golongan] || nilai['A'] || 0;
            } else {
                uangHarian = nilai;
            }
        }
        
        const totalUH = uangHarian * hari;
        totalUangHarianSpan.innerText = totalUH.toLocaleString('id-ID');
        
        // Estimasi total (belum termasuk transport & hotel karena input manual)
        totalEstimasiSpan.innerText = totalUH.toLocaleString('id-ID') + ' + (transport + hotel)';
    }

    tujuanSelect.addEventListener('change', updateUangHarian);
    golonganSelect.addEventListener('change', updateUangHarian);
    eselonSelect.addEventListener('change', updateRepresentasi);
</script>
@endsection