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
            'NpApp_Menu_Config' => 'NpApp\Service\MenuFilesFactory'
        ),
        'shared' => array(
        ),
    ),
    'di' => array(
        //'definition' => include __DIR__ . '/definition.php',
        'instance' => include __DIR__ . '/instance.models.php',
    ),
    'menu_files' => array(
        'spec_class' => 'Flower\File\Spec\TreeArrayMerge',
        'spec_options' => array(
        ),
        'resolve_spec_class' => 'Flower\File\Spec\Resolver\Tree',
        'resolve_spec_options' => array(
            'map' => [],
            'extensions' => ['menu'=>'menu.php'],
            'path_stack' => array(
                'flower' => __DIR__ . '/pages',
            ),
        ),
        'cache_spec_options' => array(
            /*'cache_path' => __DIR__ . '/../data/cache/menu',*/
            'cache_enabled' => false,
        ),
    ),
    'translator' => array(
        'locale' => 'ja_JP',
        'translation_files' => array(
            array(
                'type' => 'phpArray',
                'filename' => __DIR__ . '/../../../vendor/zendframework/zendframework/resources/languages/ja/Zend_Validate.php',
                'text_domain' => 'default',
                'locale' => 'ja_JP',
            ),
        ),
        /*
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../../Application/language',
                'pattern'  => '%s.mo',
            ),
        ),*/
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
    'flower_pane' => Array (
        'builder_options' => array(
            'size_to_class_function' => function($size) { 
                $size = intval($size);
                if ($size > 20) {
                    return '';
                }
                $sizeList = array('zero', 'one', 'two', 'three', 'four', 'five',
                    'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve',
                    'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen',
                    'eightteen', 'nineteen', 'twenty');
                return $sizeList[$size] . ' columns';
            },
        ),
    )
);
