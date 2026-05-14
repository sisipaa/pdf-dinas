<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<style>

    @page {
        margin: 25px 30px;
    }

    body{
        font-family:"Times New Roman", serif;
        font-size:11pt;
        color:#000;
        line-height:1.4;
    }

    table{
        width:100%;
        border-collapse:collapse;
    }

    td,th{
        padding:5px;
        vertical-align:top;
    }

    .border td,
    .border th{
        border:1px solid #000;
    }

    .center{
        text-align:center;
    }

    .right{
        text-align:right;
    }

    .bold{
        font-weight:bold;
    }

    .judul{
        text-align:center;
        font-size:13pt;
        font-weight:bold;
        margin-bottom:15px;
    }

    .page-break{
        page-break-after:always;
    }

    .no-border td{
        border:none !important;
    }

    /* KHUSUS NOMINATIF */
    .landscape-page{
        page: landscapePage;
    }

    @page landscapePage{
        size:A4 landscape;
        margin:20px;
    }

</style>
</head>

<body>

@include('trips.dalam-negeri.partials.spd')

<div class="page-break"></div>

@include('trips.dalam-negeri.partials.rincian')

<div class="page-break"></div>

@include('trips.dalam-negeri.partials.kwitansi')

<div class="page-break"></div>

@include('trips.dalam-negeri.partials.riil')

<div class="page-break"></div>

<div class="landscape-page">

@include('trips.dalam-negeri.partials.nominatif')

</div>

<div class="page-break"></div>

@include('trips.dalam-negeri.partials.perjalanan')

</body>
</html>