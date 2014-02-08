<?php
return array(
    'controllers' => array(
        'invokables' => include __DIR__ . '/invokables.php',
    ),
    'service_manager' => array(
        //Module.phpの getServiceConfigでも実装できる。ハードコートしたくなければこちらで。
        'factories' => array(
            'NpApp_Repositories'
                => 'NpApp\Service\RepositoryServiceFactory',
            'smtp_transport'  => 'Flower\Mail\SmtpTransportFactory',
            'PaneFileListener' => 'Flower\View\Pane\Service\ConfigFileListenerFactory',
            'PaneCacheListener' => 'Flower\View\Pane\Service\PaneCacheListenerFactory',
            'PaneRenderCacheListener' => 'Flower\View\Pane\Service\RenderCacheListenerFactory',
        ),
        'shared' => array(
        ),
    ),
    'view_helpers' => array(
        'factories' => array(
            'NpPaneManager' => 'Flower\View\Pane\Service\ManagerFactory',
        ),
    ),
    'flower_pane_manager' => include 'flower_pane_manager.php',
    'pane_config_file_listener' => include 'pane_config_file_options.php',
    'pane_cache_listener' => include 'pane_cache_options.php',
    'render_cache_listener' => include 'pane_render_cache_options.php',
    'di' => array(
        //'definition' => include __DIR__ . '/definition.php',
        'instance' => include __DIR__ . '/instance.models.php',
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
);
