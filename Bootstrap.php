<?php

namespace serega170584\file;

/**
 * Class Bootstrap
 */
class Bootstrap implements \yii\base\BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules([
            'a5821f3c408380773281eb7a544c9b2c' => 'a5821f3c408380773281eb7a544c9b2c/upload-file/index'
        ], false);
        $app->setModule('a5821f3c408380773281eb7a544c9b2c', 'serega170584\file\Module');
    }
}