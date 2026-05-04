<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
    body { 
        font-family: "Times New Roman", Times, serif; 
        font-size: 12pt; 
        margin: 0;
        padding: 20px;
    }
    .page-break { 
        page-break-after: always; 
    }
    table { 
        width: 100%; 
        border-collapse: collapse; 
    }
    td, th { 
        padding: 6px; 
        vertical-align: top;
    }
    .border td, .border th {
        border: 1px solid black;
    }
    .center { 
        text-align: center; 
    }
    .right { 
        text-align: right; 
    }
    .left {
        text-align: left;
    }
    hr {
        margin: 10px 0;
    }
    .bold {
        font-weight: bold;
    }
</style>
</head>
<body>

@include('trips.luar-negeri.partials.spd')
<div class="page-break"></div>

@include('trips.luar-negeri.partials.perjalanan')
<div class="page-break"></div>

@include('trips.luar-negeri.partials.rincian')
<div class="page-break"></div>

@include('trips.luar-negeri.partials.kwitansi')
<div class="page-break"></div>

@include('trips.luar-negeri.partials.riil')

</body>
</html>