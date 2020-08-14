@php

use lib\Base\Support\Config;

@endphp

@define ('plus', 'x', 'y') :x + :y @enddefine

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>{{ Config::get('app', 'name', 'None') }}</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

        <script src="js/jquery-3.5.1.min.js" defer></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous" defer></script>
        <script src="js/bootstrap.min.js" defer></script>
        <script src="js/bootstrap.bundle.min.js" defer></script>
    </head>
    <body class="">
        @section('content')
    </body>
</html>