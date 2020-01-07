<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>{{$titulo}}</title>
    <style type="text/css">
        /* Mantém o TD abaixo do THEAD nas páginas */
        thead {
            display: table-header-group
        }

        tfoot {
            display: table-row-group
        }

        tr {
            page-break-inside: avoid
        }

        #header p {
            margin: 0;
            width: 100%;
        }

        #num_os {
            font-size: 16px;
            font-weight: bold;
        }

        #body {
            margin-top: 30px !important;
        }

        table {
            width: 100%;
        }

        table tr td,
        table tr th {
            border: 0.5px solid #ddd;
            padding: 5px;
        }

        table,
        td,
        tr,
        th {
            border-collapse: collapse;
            font-family: sans-serif;
            font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
        }

        table th {
            height: auto;
            font-size: 12px;
            padding: 5px 10px 2px;
            text-align: center;
            color: #666666;
            vertical-align: middle;
            background: #efefef;
            font-weight: bold;
            line-height: 20px;
        }

        table td {
            vertical-align: middle;
            font-size: 12px;
        }

        #footer {
            color: #DDD;
            font-weight: bold;
            font-style: italic;
            text-align: right;
            font-size: 12px;
            border-top: 1px solid #DDD;
            margin-top: 30px;
        }

        #footer {
            float: static(bottom)
        }

        .text-right {
            text-align: right;
        }

        .linha_total {
            background-color: #CCC !important;
            font-weight: bold;
        }

        .linha_total td {
            text-align: right;
        }

        .pull-right {
            float: right;
        }

        .pull-left {
            float: left;
        }

        h3.empresa {
            width: 50%;
            display: inline;
        }

        p.parametros {
            width: 50%;
            text-align: right;
            float: right;
        }
    </style>
</head>

<body>
    <div id="header">
        <h1>{{$titulo}}</h1>
        @if(@$parametros)
        @foreach($parametros as $key => $value)
        @if($value == 'Todos' || blank($value)) @continue @endif
        <p class="parametros"><strong>{{$key}}: </strong>{{$value}}</p>
        @endforeach
        @endif
        <hr>
    </div>
    <div id="body">
        @yield('content')
    </div>
</body>

</html>