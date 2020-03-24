<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;
use yii\bootstrap\BootstrapAsset;

class AuthAsset extends AssetBundle{
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [
	    '/css/site.css',
	];
	public $js = [
	];
	public $depends = [
        YiiAsset::class,
        BootstrapAsset::class,
	];
}