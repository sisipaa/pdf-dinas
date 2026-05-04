<b>I. Berangkat dari:</b> {{ $trip->tempat_keberangkatan }} (Indonesia)<br>
<b>Ke:</b> {{ $trip->tujuan }}<br>
<b>Tanggal:</b> {{ \Carbon\Carbon::parse($trip->tanggal_keberangkatan)->translatedFormat('d F Y') }}

<br><br>

<b>II. Tiba di:</b> {{ $trip->tujuan }}<br>
<b>Tanggal:</b> {{ \Carbon\Carbon::parse($trip->tanggal_keberangkatan)->translatedFormat('d F Y') }}

<br><br>

<b>III. Kembali ke:</b> {{ $trip->tempat_keberangkatan }} (Indonesia)<br>
<b>Tanggal:</b> {{ \Carbon\Carbon::parse($trip->tanggal_kembali)->translatedFormat('d F Y') }}

<br><br>

<b>Pejabat Pembuat Komitmen</b><br><br><br>
(____________________)