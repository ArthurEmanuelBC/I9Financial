<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title><?php echo e($titulo); ?></title>
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

        table.no-border tr th,
        table.no-border tr td {
            border: 0;
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
        <h1><?php echo e($titulo); ?></h1>
        <?php if(@$parametros): ?>
        <?php foreach($parametros as $key => $value): ?>
        <?php if($value == 'Todos' || blank($value)): ?> <?php continue; ?> <?php endif; ?>
        <p class="parametros"><strong><?php echo e($key); ?>: </strong><?php echo e($value); ?></p>
        <?php endforeach; ?>
        <?php endif; ?>
        <hr>
    </div>
    <div id="body">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
</body>

</html>