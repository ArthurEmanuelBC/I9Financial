<?php

return array(


    'pdf' => array(
        'enabled' => true,
        // 'binary'  => base_path('vendor/h4cc/wkhtmltopdf/bin/wkhtmltopdf'), // LOCAL
        'binary'  => base_path('vendor/h4cc/wkhtmltopdf/bin/wkhtmltopdf-amd64'), // SERVER
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => true,
        // 'binary'  => base_path('vendor/h4cc/wkhtmltopdf/bin/wkhtmltoimage'), // LOCAL
        'binary'  => base_path('vendor/h4cc/wkhtmltoimage-amd64/bin/wkhtmltoimage-amd64'), // SERVER
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),


);
