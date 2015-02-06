<?php
return array(
    'service_manager' => array(
        //Module.phpの getServiceConfigでも実装できる。ハードコートしたくなければこちらで。
        'factories' => array(
            'NpApp_Repositories'
                => 'NpApp\Service\RepositoryServiceFactory',
        ),
        'shared' => array(
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'np-app' => __DIR__ . '/../view',
        ),
        /**
         * デフォルト設定
         * 実際にはスケルトン側や各ドメイン毎のモジュールを優先するべき
         * 探索が
         */
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
);
