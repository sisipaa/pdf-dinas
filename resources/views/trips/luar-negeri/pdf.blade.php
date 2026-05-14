<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>
        body{
            font-family:"Times New Roman", serif;
            font-size:12px;
            line-height:1.5;
            margin:25px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        td,th{
            padding:4px;
            vertical-align:top;
        }

        .border{
            border:1px solid black;
        }

        .text-center{
            text-align:center;
        }

        .text-right{
            text-align:right;
        }

        .title{
            font-size:16px;
            font-weight:bold;
            margin-top:10px;
            margin-bottom:20px;
        }

        .page-break{
            page-break-after:always;
        }

        hr{
            border:1px solid black;
        }

        /* LANDSCAPE UNTUK NOMINATIF */
        @page landscapePage {
            size: A4 landscape;
            margin: 20px;
        }

        .landscape-page {
            page: landscapePage;
        }
    </style>
</head>

<body>

    @include('trips.luar-negeri.partials.spd')

    <div class="page-break"></div>

    @include('trips.luar-negeri.partials.rincian')

    <div class="page-break"></div>

    @include('trips.luar-negeri.partials.kwitansi')

    <div class="page-break"></div>

    @include('trips.luar-negeri.partials.riil')

    <div class="page-break"></div>

    <div class="landscape-page">
        @include('trips.luar-negeri.partials.nominatif')
    </div>

    <div class="page-break"></div>

    @include('trips.luar-negeri.partials.perjalanan')

</body>
</html>