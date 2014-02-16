<?php
return array(
    'service_manager' => array(
        //Module.phpの getServiceConfigでも実装できる。ハードコートしたくなければこちらで。
        'factories' => array(
            'NpApp_Repositories'
                => 'NpApp\Service\RepositoryServiceFactory',
            'smtp_transport'  => 'Flower\Mail\SmtpTransportFactory',
        ),
        'shared' => array(
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'np-app' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'strategies' => array(
            'ViewJsonStrategy', // register JSON renderer strategy
            'ViewFeedStrategy',
        ),
    ),
    'page' => array(
        'blocks' => array(),
        'config_resolver' => array(
            'path_stack' => array(
                'pages' => __DIR__ . '/pages',
            ),
            'map' => array(
                //'error/404'               => __DIR__ . '/../view/error/404.phtml',
                //'error/index'             => __DIR__ . '/../view/error/index.phtml',
            ),
        ),
        'error_page' => 'errorPage',
    ),
    'fprg' => array(
        'preview-route' => 'admin/file',
        'preview-params' => array(),
    ),
    'translator' => array(
        'locale' => 'ja_JP',
        'translation_files' => array(
            array(
                'type' => 'phpArray',
                'filename' => __DIR__ . '/../../vendor/zendframework/zendframework/resources/languages/ja/Zend_Validate.php',
                'text_domain' => 'default',
                'locale' => 'ja_JP',
            ),
        ),
    ),
);
