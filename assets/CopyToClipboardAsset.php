<?php

namespace app\assets;

use yii\web\AssetBundle;

class CopyToClipboardAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'js/copy_to_clipboard.js',
    ];
    public $depends = [
        'app\assets\AppAsset',
    ];
}