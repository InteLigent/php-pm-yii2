<?php

namespace PHPPM\Bootstraps;

use yii\web\Application;

class Yii2 implements BootstrapInterface
{
    /**
     * @var string
     */
    protected $appenv;

    /**
     * Instantiate the bootstrap, storing the $appenv.
     *
     * @param string $appenv
     */
    public function __construct($appenv, $debug = false)
    {
        $this->appenv = $appenv;

        putenv("YII_DEBUG=" . ($debug ? 'true' : 'false'));
        putenv("YII_ENV=" . $this->appenv);
    }

    /**
     * Create a Yii Framework MVC application.
     */
    public function getApplication()
    {
        $dir = __DIR__;

        require($dir . '/../../vendor/autoload.php');
        require($dir . '/../../vendor/yiisoft/yii2/Yii.php');

        Yii::beginProfile('Total');

        require($dir . '/../../common/config/bootstrap.php');
        require($dir . '/../config/bootstrap.php');

        $config = yii\helpers\ArrayHelper::merge(
            require($dir . '/../../common/config/main.php'),
            require($dir . '/../../common/config/main-local.php'),
            require($dir . '/../config/main.php'),
            require($dir . '/../config/main-local.php')
        );

        return new Application($config);
    }
}