<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cargo en PDF</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap');
        *{
            font-size: 11pt;
            font-weight: 400;
            font-family: sans-serif;
        }

        thead {
            display: table-header-group; 
        }
        tbody {
            display: table-header-group; 
        }
        tr { 
            page-break-inside: avoid; 
        }
    </style>
</head>
<body>
    @yield('content')

</body>

</html>