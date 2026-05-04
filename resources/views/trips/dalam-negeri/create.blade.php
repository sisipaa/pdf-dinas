@extends('layouts.app')

@section('title', 'Input Perjalanan Dinas Dalam Negeri')

@section('content')
<div style="max-width:900px; margin:auto; background:#fff; padding:20px; border-radius:8px;">

    <h2 style="text-align:center; margin-bottom:20px;">Form Perjalanan Dinas Dalam Negeri</h2>

    <form action="{{ route('trips.dalam-negeri.store') }}" method="POST">
        @csrf

        <fieldset style="border:1px solid #ddd; padding:15px; margin-bottom:20px; border-radius:5px;">
            <legend style="font-weight:bold;">Data Pegawai</legend>

            <div style="margin-bottom:10px;">
                <label>Nama Lengkap</label><br>
                <input type="text" name="nama" required style="width:100%; padding:8px;">
            </div>

            <div style="margin-bottom:10px;">
                <label>NIP</label><br>
                <input type="text" name="nip" required style="width:100%; padding:8px;">
            </div>

            <div style="margin-bottom:10px;">
                <label>Pangkat</label><br>
                <input type="text" name="pangkat" required style="width:100%; padding:8px;">
            </div>

            <div style="margin-bottom:10px;">
                <label>Golongan (Contoh: IV/a, III/b, dll)</label><br>
                <input type="text" name="golongan" required style="width:100%; padding:8px;">
            </div>

            <div style="margin-bottom:10px;">
                <label>Jabatan</label><br>
                <input type="text" name="jabatan" required style="width:100%; padding:8px;">
            </div>

            <div style="margin-bottom:10px;">
                <label>Eselon</label><br>
                <select name="eselon" required style="width:100%; padding:8px;">
                    <option value="pejabat_negara">Pejabat Negara/Wakil Menteri</option>
                    <option value="eselon_i">Eselon I</option>
                    <option value="eselon_ii">Eselon II</option>
                    <option value="eselon_iii">Eselon III ke bawah</option>
                </select>
                <small style="color:#666;">*Mempengaruhi uang representasi (Eselon I: Rp200.000/hari, Eselon II: Rp150.000/hari)</small>
            </div>
        </fieldset>

        <fieldset style="border:1px solid #ddd; padding:15px; margin-bottom:20px; border-radius:5px;">
            <legend style="font-weight:bold;">Data Perjalanan</legend>

            <div style="margin-bottom:10px;">
                <label>Nomor Surat (Opsional)</label><br>
                <input type="text" name="nomor_surat" style="width:100%; padding:8px;">
            </div>

            <div style="margin-bottom:10px;">
                <label>Maksud Perjalanan</label><br>
                <textarea name="maksud_perjalanan" rows="3" required style="width:100%; padding:8px;"></textarea>
            </div>

            <div style="margin-bottom:10px;">
                <label>Jenis Angkutan</label><br>
                <select name="jenis_angkutan" required style="width:100%; padding:8px;">
                    <option value="darat">Darat</option>
                    <option value="udara">Udara</option>
                </select>
            </div>

            <div style="margin-bottom:10px;">
                <label>Tempat Keberangkatan</label><br>
                <input type="text" name="tempat_keberangkatan" required style="width:100%; padding:8px;">
            </div>

            <div style="margin-bottom:10px;">
                <label>Provinsi Tujuan</label><br>
                <select name="tujuan" id="tujuan" required style="width:100%; padding:8px;">
                    <option value="">Pilih Provinsi Tujuan</option>
                    @foreach($provinsiOptions as $provinsi)
                        <option value="{{ $provinsi }}">{{ $provinsi }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom:10px;">
                <label>Tanggal Keberangkatan</label><br>
                <input type="date" name="tanggal_keberangkatan" id="tanggal_berangkat" required style="width:100%; padding:8px;">
            </div>

            <div style="margin-bottom:10px;">
                <label>Tanggal Kembali</label><br>
                <input type="date" name="tanggal_kembali" id="tanggal_kembali" required style="width:100%; padding:8px;">
            </div>

            <div style="margin-bottom:10px;">
                <label>Lama Hari (Otomatis)</label><br>
                <input type="number" name="lama_hari" id="lama_hari" readonly style="width:100%; padding:8px; background:#f0f0f0;">
            </div>
        </fieldset>

        <fieldset style="border:1px solid #ddd; padding:15px; margin-bottom:20px; border-radius:5px;">
            <legend style="font-weight:bold;">Biaya Transportasi</legend>

            <div style="margin-bottom:10px;">
                <label>Biaya Transport Berangkat (Pesawat/Kereta/Bus)</label><br>
                <input type="number" name="biaya_transport_berangkat" value="0" step="1000" style="width:100%; padding:8px;">
                <small>Input manual sesuai harga tiket</small>
            </div>

            <div style="margin-bottom:10px;">
                <label>Biaya Taxi di Jakarta (Bandara/Stasiun/Terminal ke Lokasi)</label><br>
                <input type="number" name="biaya_taxi_jakarta" id="biaya_taxi_jakarta" readonly style="width:100%; padding:8px; background:#f0f0f0;">
                <small>Fixed: Rp {{ number_format(config('uang-harian.taxi_jakarta'),0,',','.') }} per trip</small>
            </div>

            <div style="margin-bottom:10px;">
                <label>Jenis Taxi Jakarta</label><br>
                <select name="jenis_taxi_jakarta" style="width:100%; padding:8px;">
                    <option value="sekali_jalan">Sekali Jalan</option>
                    <option value="pp">Pulang Pergi (2x)</option>
                </select>
            </div>

            <div style="margin-bottom:10px;">
                <label>Biaya Transport Pulang (Pesawat/Kereta/Bus)</label><br>
                <input type="number" name="biaya_transport_pulang" value="0" step="1000" style="width:100%; padding:8px;">
            </div>

            <div style="margin-bottom:10px;">
                <label>Biaya Taxi di Kota Tujuan (Dari Bandara/Stasiun/Terminal ke Lokasi)</label><br>
                <input type="number" name="biaya_taxi_tujuan" id="biaya_taxi_tujuan" readonly style="width:100%; padding:8px; background:#f0f0f0;">
                <small>Akan terisi otomatis berdasarkan provinsi tujuan</small>
            </div>

            <div style="margin-bottom:10px;">
                <label>Biaya Transport Dalam Kota Jakarta (Selama Perjalanan)</label><br>
                <input type="number" name="biaya_dalam_kota" id="biaya_dalam_kota" readonly style="width:100%; padding:8px; background:#f0f0f0;">
                <small>Fixed: Rp {{ number_format(config('uang-harian.dalam_kota_jakarta'),0,',','.') }} (jika perjalanan di Jakarta)</small>
            </div>

            <div style="margin-bottom:10px;">
                <label>Transportasi Jakarta ke Kab/Kota Sekitar (Jika ke Bodetabek)</label><br>
                <select name="biaya_transport_sekitar_jakarta" id="transport_sekitar" style="width:100%; padding:8px;">
                    <option value="0">Tidak ada / bukan sekitar Jakarta</option>
                    @foreach($kabupatenSekitarJakarta as $kab)
                        <option value="{{ $kab }}">{{ $kab }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom:10px;">
                <label>Biaya Hotel (Penginapan)</label><br>
                <input type="number" name="biaya_hotel" value="0" step="10000" style="width:100%; padding:8px;">
            </div>
        </fieldset>

        <div style="background:#e8f4f8; padding:15px; border-radius:5px; margin-bottom:20px;">
            <h4>Ringkasan Otomatis:</h4>
            <p>💰 <strong>Uang Harian per hari:</strong> <span id="uang_harian_per_hari">-</span> IDR</p>
            <p>🎖️ <strong>Uang Representasi per hari:</strong> <span id="uang_representasi_per_hari">-</span> IDR</p>
            <p>📊 <strong>Total Perkiraan Biaya:</strong> <span id="total_estimasi">-</span> IDR</p>
        </div>

        <button type="submit" style="background:#28a745; color:#fff; padding:12px 24px; border:none; border-radius:5px; cursor:pointer; font-size:16px;">
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
        }
    }

    tglBerangkat.addEventListener('change', hitungLamaHari);
    tglKembali.addEventListener('change', hitungLamaHari);

    // Set fixed biaya
    document.getElementById('biaya_taxi_jakarta').value = {{ config('uang-harian.taxi_jakarta') }};
    document.getElementById('biaya_dalam_kota').value = {{ config('uang-harian.dalam_kota_jakarta') }};

    // Ambil biaya taxi tujuan berdasarkan provinsi
    const tujuanSelect = document.getElementById('tujuan');
    const biayaTaxiTujuan = document.getElementById('biaya_taxi_tujuan');
    const uangHarianSpan = document.getElementById('uang_harian_per_hari');
    const representasiSpan = document.getElementById('uang_representasi_per_hari');

    const taxiTujuanData = @json(config('uang-harian.transportasi_terminal_tujuan'));
    const uangHarianData = @json(config('uang-harian.dalam_negeri'));

    tujuanSelect.addEventListener('change', function() {
        const provinsi = this.value;
        if (taxiTujuanData[provinsi]) {
            biayaTaxiTujuan.value = taxiTujuanData[provinsi];
        } else {
            biayaTaxiTujuan.value = {{ config('uang-harian.default_transportasi_terminal') }};
        }

        if (uangHarianData[provinsi]) {
            uangHarianSpan.innerText = new Intl.NumberFormat('id-ID').format(uangHarianData[provinsi]);
        } else {
            uangHarianSpan.innerText = '-';
        }
    });

    // Update representasi berdasarkan eselon
    const eselonSelect = document.querySelector('select[name="eselon"]');
    const representasiData = {
        'pejabat_negara': 250000,
        'eselon_i': 200000,
        'eselon_ii': 150000,
        'eselon_iii': 0
    };

    eselonSelect.addEventListener('change', function() {
        const val = representasiData[this.value] || 0;
        representasiSpan.innerText = new Intl.NumberFormat('id-ID').format(val);
    });
</script>
@endsection