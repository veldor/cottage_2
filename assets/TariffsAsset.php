<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;
use yii\bootstrap\BootstrapAsset;

class TariffsAsset extends AssetBundle{
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [
	    '/css/site.css'
	];
	public $js = [
	    '/js/globals.js',
	    '/js/tariffs.js'
	];
	public $depends = [
        YiiAsset::class,
        BootstrapAsset::class,
	];
}