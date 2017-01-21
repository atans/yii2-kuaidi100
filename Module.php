<?php

namespace atans\kuaidi100;

use Yii;
use yii\base\Module as BaseModule;
use yii\i18n\PhpMessageSource;

class Module extends BaseModule
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $app = Yii::$app;

        if (! isset($app->i18n->translations['kuaidi100*'])) {
            $app->i18n->translations['kuaidi100*'] = [
                'class'    => PhpMessageSource::className(),
                'basePath' => __DIR__ . '/messages',
            ];
        }

        parent::init();
    }
}