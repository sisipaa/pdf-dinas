@extends('layouts.app')

@section('title', 'Input Perjalanan Dinas Dalam Negeri')

@section('content')
<div style="max-width:900px; margin:auto; background:#fff; padding:20px; border-radius:8px;">

    <h2 style="text-align:center; margin-bottom:20px;">Form Perjalanan Dinas Dalam Negeri</h2>

    <form action="{{ route('trips.dalam-negeri.store') }}" method="POST" id="formDinas">
        @csrf

        <!-- DATA PEGAWAI -->
        <fieldset style="border:1px solid #ddd; padding:15px; margin-bottom:20px; border-radius:5px;">
            <legend style="font-weight:bold;">Data Pegawai</legend>

            <div style="margin-bottom:10px;">
                <label>Nama Lengkap *</label><br>
                <input type="text" name="nama" required style="width:100%; padding:8px;">
            </div>

            <div style="margin-bottom:10px;">
                <label>NIP *</label><br>
                <input type="text" name="nip" required style="width:100%; padding:8px;">
            </div>

            <div style="margin-bottom:10px;">
                <label>Pangkat (Opsional)</label><br>
                <input type="text" name="pangkat" style="width:100%; padding:8px;">
            </div>

            <div style="margin-bottom:10px;">
                <label>Golongan (Opsional - Contoh: IV/a, III/b)</label><br>
                <input type="text" name="golongan" style="width:100%; padding:8px;">
            </div>

            <div style="margin-bottom:10px;">
                <label>Jabatan *</label><br>
                <input type="text" name="jabatan" required style="width:100%; padding:8px;">
            </div>

            <div style="margin-bottom:10px;">
                <label>Eselon (Opsional)</label><br>
                <select name="eselon" id="eselon" style="width:100%; padding:8px;">
                    @foreach($eselonOptions as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </fieldset>

        <!-- JENIS PERJALANAN -->
        <fieldset style="border:1px solid #ddd; padding:15px; margin-bottom:20px; border-radius:5px;">
            <legend style="font-weight:bold;">Jenis Perjalanan</legend>

            <div style="margin-bottom:10px;">
                <label>Pilih Jenis Perjalanan *</label><br>
                <select name="jenis_perjalanan" id="jenis_perjalanan" required style="width:100%; padding:8px;">
                    <option value="">-- Pilih Jenis Perjalanan --</option>
                    <option value="fullboard">📋 Meet Full Board (Rp130.000/hari)</option>
                    <option value="dalam_kota_jakarta">🏙️ Dinas Dalam Kota Jakarta</option>
                    <option value="sekitar_jakarta">🚗 Dinas Sekitar Jakarta (Jabodetabek)</option>
                    <option value="luar_kota">✈️ Dinas Luar Kota</option>
                </select>
            </div>
        </fieldset>

        <!-- DATA PERJALANAN -->
        <fieldset style="border:1px solid #ddd; padding:15px; margin-bottom:20px; border-radius:5px;">
            <legend style="font-weight:bold;">Data Perjalanan</legend>

            <div style="margin-bottom:10px;">
                <label>Nomor Surat (Opsional)</label><br>
                <input type="text" name="nomor_surat" style="width:100%; padding:8px;">
            </div>

            <div style="margin-bottom:10px;">
                <label>Maksud Perjalanan *</label><br>
                <textarea name="maksud_perjalanan" rows="3" required style="width:100%; padding:8px;"></textarea>
            </div>

            <!-- Hanya untuk luar kota -->
            <div id="div_angkutan" style="display:none; margin-bottom:10px;">
                <label>Jenis Angkutan</label><br>
                <select name="jenis_angkutan" style="width:100%; padding:8px;">
                    <option value="darat">Darat</option>
                    <option value="udara">Udara</option>
                </select>
            </div>

            <!-- Hanya untuk luar kota -->
            <div id="div_tempat_berangkat" style="display:none; margin-bottom:10px;">
                <label>Tempat Keberangkatan</label><br>
                <input type="text" name="tempat_keberangkatan" value="Jakarta" style="width:100%; padding:8px;">
            </div>

            <!-- Tujuan untuk luar kota & sekitar jakarta -->
            <div id="div_tujuan_provinsi" style="display:none; margin-bottom:10px;">
                <label>Provinsi Tujuan</label><br>
                <select name="tujuan" id="tujuan_select" style="width:100%; padding:8px;">
                    <option value="">Pilih Provinsi</option>
                    @foreach($provinsiOptions as $provinsi)
                        @if($provinsi != 'DKI Jakarta')
                            <option value="{{ $provinsi }}">{{ $provinsi }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <!-- Tujuan untuk sekitar jakarta -->
            <div id="div_tujuan_sekitar" style="display:none; margin-bottom:10px;">
                <label>Kota Tujuan (Sekitar Jakarta)</label><br>
                <select name="tujuan" id="tujuan_sekitar" style="width:100%; padding:8px;">
                    <option value="">Pilih Kota</option>
                    @foreach($kabupatenSekitarJakarta as $kota => $biaya)
                        <option value="{{ $kota }}" data-biaya="{{ $biaya }}">{{ $kota }} (Rp{{ number_format($biaya,0,',','.') }})</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom:10px;">
                <label>Tanggal Keberangkatan *</label><br>
                <input type="date" name="tanggal_keberangkatan" id="tanggal_berangkat" required style="width:100%; padding:8px;">
            </div>

            <div style="margin-bottom:10px;">
                <label>Tanggal Kembali *</label><br>
                <input type="date" name="tanggal_kembali" id="tanggal_kembali" required style="width:100%; padding:8px;">
            </div>

            <div style="margin-bottom:10px;">
                <label>Lama Hari (Otomatis)</label><br>
                <input type="number" name="lama_hari" id="lama_hari" readonly style="width:100%; padding:8px; background:#f0f0f0;">
            </div>
        </fieldset>

        <!-- BIAYA -->
        <fieldset style="border:1px solid #ddd; padding:15px; margin-bottom:20px; border-radius:5px;">
            <legend style="font-weight:bold;">Biaya</legend>

            <!-- Uang harian manual untuk dalam kota jakarta -->
            <div id="div_uang_harian_manual" style="display:none; margin-bottom:10px;">
                <label>Uang Harian per Hari (Rp)</label><br>
                <input type="number" name="uang_harian_manual" id="uang_harian_manual" value="210000" style="width:100%; padding:8px;">
                <small>Default: Rp210.000 (Dalam Kota Jakarta >8 Jam)</small>
            </div>

            <!-- Biaya transport umum -->
            <div id="div_transport_berangkat" style="display:none; margin-bottom:10px;">
                <label>Biaya Transport Berangkat (Rp)</label><br>
                <input type="number" name="biaya_transport_berangkat" value="0" style="width:100%; padding:8px;">
                <small>Input manual harga tiket</small>
            </div>

            <div id="div_transport_pulang" style="display:none; margin-bottom:10px;">
                <label>Biaya Transport Pulang (Rp)</label><br>
                <input type="number" name="biaya_transport_pulang" value="0" style="width:100%; padding:8px;">
                <small>Input manual harga tiket</small>
            </div>

            <!-- Taxi keberangkatan -->
            <div id="div_taxi_berangkat" style="display:none; margin-bottom:10px;">
                <label>Biaya Taxi ke Bandara/Stasiun/Terminal (Rp)</label><br>
                <input type="number" name="biaya_taxi_keberangkatan" id="biaya_taxi_keberangkatan" style="width:100%; padding:8px;" readonly>
                <small>Otomatis sesuai lokasi keberangkatan</small>
            </div>

            <!-- Taxi tujuan -->
            <div id="div_taxi_tujuan" style="display:none; margin-bottom:10px;">
                <label>Biaya Taxi di Kota Tujuan (Rp)</label><br>
                <input type="number" name="biaya_taxi_tujuan" id="biaya_taxi_tujuan" style="width:100%; padding:8px;" readonly>
                <small>Otomatis sesuai provinsi tujuan</small>
            </div>

            <div style="margin-bottom:10px;">
                <label>Biaya Hotel/Penginapan (Rp)</label><br>
                <input type="number" name="biaya_hotel" value="0" style="width:100%; padding:8px;">
            </div>
        </fieldset>

        <!-- RINGKASAN -->
        <div style="background:#e8f4f8; padding:15px; border-radius:5px; margin-bottom:20px;">
            <h4>Ringkasan:</h4>
            <p>💰 <strong>Uang Harian/hari:</strong> <span id="display_uang_harian">-</span></p>
            <p>🎖️ <strong>Uang Representasi/hari:</strong> <span id="display_representasi">Rp 0</span></p>
            <p>📊 <strong>Total Perkiraan:</strong> <span id="display_total">-</span></p>
        </div>

        <button type="submit" style="background:#28a745; color:#fff; padding:12px 24px; border:none; border-radius:5px; cursor:pointer; font-size:16px;">
            💾 Simpan & Generate PDF
        </button>
        
        <form action="{{ route('trips.dalam-negeri.store') }}" method="POST" id="formDinas" onsubmit="return disableSubmit()">


    </form>
</div>

<script>
// Data dari config
const taxiTujuanData = @json($taxiTujuanData);
const uangHarianData = @json(config('uang-harian.dalam_negeri'));
const transportSekitarData = @json($kabupatenSekitarJakarta);

// Hitung lama hari
const tglBerangkat = document.getElementById('tanggal_berangkat');
const tglKembali = document.getElementById('tanggal_kembali');
const lamaHari = document.getElementById('lama_hari');

function hitungLamaHari() {
    if (tglBerangkat.value && tglKembali.value) {
        const start = new Date(tglBerangkat.value);
        const end = new Date(tglKembali.value);
        const diff = Math.ceil(Math.abs(end - start) / (1000*60*60*24)) + 1;
        lamaHari.value = diff;
        updateTotal();
    }
}
tglBerangkat.addEventListener('change', hitungLamaHari);
tglKembali.addEventListener('change', hitungLamaHari);

// Jenis perjalanan
const jenisSelect = document.getElementById('jenis_perjalanan');
const semuaDiv = ['div_angkutan','div_tempat_berangkat','div_tujuan_provinsi','div_tujuan_sekitar',
                  'div_transport_berangkat','div_transport_pulang','div_taxi_berangkat','div_taxi_tujuan',
                  'div_uang_harian_manual'];

jenisSelect.addEventListener('change', function() {
    const val = this.value;
    
    // Sembunyikan semua dulu
    semuaDiv.forEach(d => document.getElementById(d).style.display = 'none');
    
    // Tampilkan sesuai jenis
    if (val === 'fullboard') {
        document.getElementById('display_uang_harian').innerText = 'Rp 130.000';
        updateTotal();
    } else if (val === 'dalam_kota_jakarta') {
        document.getElementById('div_uang_harian_manual').style.display = 'block';
        document.getElementById('display_uang_harian').innerText = 'Rp 210.000';
        updateTotal();
    } else if (val === 'sekitar_jakarta') {
        document.getElementById('div_tujuan_sekitar').style.display = 'block';
        document.getElementById('display_uang_harian').innerText = 'Rp 430.000';
        updateTotal();
    } else if (val === 'luar_kota') {
        document.getElementById('div_angkutan').style.display = 'block';
        document.getElementById('div_tempat_berangkat').style.display = 'block';
        document.getElementById('div_tujuan_provinsi').style.display = 'block';
        document.getElementById('div_transport_berangkat').style.display = 'block';
        document.getElementById('div_transport_pulang').style.display = 'block';
        document.getElementById('div_taxi_berangkat').style.display = 'block';
        document.getElementById('div_taxi_tujuan').style.display = 'block';
    }
});

// Update taxi & uang harian saat pilih provinsi
document.getElementById('tujuan_select').addEventListener('change', function() {
    const prov = this.value;
    if (taxiTujuanData[prov]) {
        document.getElementById('biaya_taxi_tujuan').value = taxiTujuanData[prov];
    }
    if (uangHarianData[prov]) {
        document.getElementById('display_uang_harian').innerText = 'Rp ' + uangHarianData[prov].luar_kota.toLocaleString('id-ID');
    }
    updateTotal();
});

// Update biaya sekitar jakarta
document.getElementById('tujuan_sekitar').addEventListener('change', function() {
    const opt = this.options[this.selectedIndex];
    const biaya = opt.getAttribute('data-biaya');
    if (biaya) {
        // Set hidden input untuk biaya transport sekitar
        let input = document.querySelector('input[name="biaya_transport_sekitar"]');
        if (!input) {
            input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'biaya_transport_sekitar';
            document.getElementById('formDinas').appendChild(input);
        }
        input.value = biaya;
    }
    updateTotal();
});

// Update representasi
document.getElementById('eselon').addEventListener('change', function() {
    const representasi = {'pejabat_negara':250000, 'eselon_i':200000, 'eselon_ii':150000};
    const val = representasi[this.value] || 0;
    document.getElementById('display_representasi').innerText = 'Rp ' + val.toLocaleString('id-ID');
    updateTotal();
});

// Update uang harian manual
document.getElementById('uang_harian_manual').addEventListener('input', function() {
    document.getElementById('display_uang_harian').innerText = 'Rp ' + parseInt(this.value||0).toLocaleString('id-ID');
    updateTotal();
});

function updateTotal() {
    const hari = parseInt(lamaHari.value) || 0;
    const uhText = document.getElementById('display_uang_harian').innerText.replace(/[^0-9]/g,'');
    const repText = document.getElementById('display_representasi').innerText.replace(/[^0-9]/g,'');
    const uh = parseInt(uhText) || 0;
    const rep = parseInt(repText) || 0;
    const total = (uh + rep) * hari;
    document.getElementById('display_total').innerText = 'Rp ' + total.toLocaleString('id-ID') + ' + transport + hotel';
}

function disableSubmit() {
    const btn = document.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.innerText = 'Menyimpan...';
    return true;
}
</script>
@endsection