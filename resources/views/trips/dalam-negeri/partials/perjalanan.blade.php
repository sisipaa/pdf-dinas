<b>I. Berangkat dari:</b> {{ $trip->tempat_keberangkatan }}<br>
Ke: {{ $trip->tujuan }}<br>
Tanggal: {{ \Carbon\Carbon::parse($trip->tanggal_keberangkatan)->translatedFormat('d F Y') }}

<br><br>

<b>II. Tiba di:</b> {{ $trip->tujuan }}<br>
Tanggal: {{ \Carbon\Carbon::parse($trip->tanggal_keberangkatan)->translatedFormat('d F Y') }}

<br><br>

<b>III. Kembali ke:</b> {{ $trip->tempat_keberangkatan }}<br>
Tanggal: {{ \Carbon\Carbon::parse($trip->tanggal_kembali)->translatedFormat('d F Y') }}

<br><br>

<b>Pejabat Pembuat Komitmen</b><br><br><br>
(____________________)