<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<style>
    @page {
        margin: 25px 30px;
    }

    body {
        font-family: "Times New Roman", Times, serif;
        font-size: 11pt;
        color: #000;
        line-height: 1.4;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    td, th {
        padding: 4px;
        vertical-align: top;
    }

    .border td,
    .border th {
        border: 1px solid #000;
    }

    .center {
        text-align: center;
    }

    .right {
        text-align: right;
    }

    .justify {
        text-align: justify;
    }

    .bold {
        font-weight: bold;
    }

    .small {
        font-size: 10pt;
    }

    .judul {
        text-align: center;
        font-weight: bold;
        font-size: 13pt;
        margin-bottom: 10px;
    }

    .page-break {
        page-break-after: always;
    }

    .no-border td {
        border: none !important;
    }

    hr {
        border: 0;
        border-top: 1px solid #000;
        margin: 5px 0;
    }

    .mt-20 {
        margin-top: 20px;
    }

    .mt-30 {
        margin-top: 30px;
    }

    .signature {
        width: 250px;
        float: right;
        text-align: center;
    }

    .logo {
        width: 80px;
    }
</style>
</head>

<body>

{{-- ================= SPD ================= --}}
@include('trips.dalam-negeri.partials.spd', ['trip' => $trip])

<div class="page-break"></div>

{{-- ================= RINCIAN ================= --}}
@include('trips.dalam-negeri.partials.rincian', ['trip' => $trip])

<div class="page-break"></div>

{{-- ================= KWITANSI ================= --}}
@include('trips.dalam-negeri.partials.kwitansi', ['trip' => $trip])

<div class="page-break"></div>

{{-- ================= RIIL ================= --}}
@include('trips.dalam-negeri.partials.riil', ['trip' => $trip])

<div class="page-break"></div>

{{-- ================= NOMINATIF ================= --}}
@include('trips.dalam-negeri.partials.nominatif', ['trip' => $trip])

<div class="page-break"></div>

{{-- ================= PERJALANAN ================= --}}
@include('trips.dalam-negeri.partials.perjalanan', ['trip' => $trip])

</body>
</html>