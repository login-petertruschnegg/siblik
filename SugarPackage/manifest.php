<?php

$manifest = array(
    'acceptable_sugar_flavors' => array('ENT', 'ULT'),
    'acceptable_sugar_versions' => array(
        'exact_matches' => array(),
        'regex_matches' => array(
            '7\.*',
        ),
    ),
    'key' => 'rt',
    'author' => 'Rolustech',
    'description' => 'Provides API to download PDFs',
    'icon' => '',
    'is_uninstallable' => true,
    'name' => 'PDF Download API',
    'published_date' => '2018-01-29 17:39:00',
    'type' => 'module',
    'version' => '1.0',
    'remove_tables' => 'prompt',
);

$installdefs = array(
    'id' => 'pdf-download-api',
    'language' => array(
        array(
            'from' => '<basepath>/en_us.lang.php',
            'to_module' => 'application',
            'language' => 'en_us',
        )
    ),
    'copy' => array(
        array(
            'from' => '<basepath>/PDFDownloadAPI.php',
            'to' => 'custom/clients/base/api/PDFDownloadAPI.php',
        )
    )
);
