<?php
return array(
    'name' => 'angular-lib',
    'options' => array(
        'viewModelBuilder' => array(
            'policy' => 'delegate',
        ),
        'blockBuilder' => function ($b) {
            $sl = $b->getService()->getServiceLocator();
            $hm = $sl->get('ViewHelperManager');
            $basePath = $hm->get('basePath');
            $bodyScript = $hm->get('bodyScript');
            $bodyScript
                ->prependFile($basePath() . '/js/libs/angular/angular-route.js')
                ->prependFile($basePath() . '/js/libs/angular/angular.js');
        },
    ),
);
 /*
<!-- : In production use:
<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.0.7/angular.min.js"></script>
-->
  */