<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    </head>
    <body class="font-sans antialiased bg-gray-100">

        <style>
        #example_wrapper .dataTables_length{
            display: inline-block;
        }
        .dataTables_paginate a span{
            border: 0.5px solid #c7c7c7;
        }
        #example_filter{
            margin: 20px 20px 20px 20px;
            float: right;
        }
        #example_filter input{
            line-height: 1em;
            border-radius: 7px;
            border: solid 0.5px rgb(204, 204, 204);
        }
        .dataTables_length{
            margin: 20px 20px 20px 20px;
        }
        .dataTables_length select{
            line-height: 1em;
            border-radius: 7px;
            border: solid 0.5px rgb(204, 204, 204);
        }
        .py-12{
            margin: 0 50px 0 50px;
        }
        </style>

        @inertia
    </body>
</html>
