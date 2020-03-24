<?php

/* @var $this yii\web\View */
/* @var $cottageList Cottage[] */

use app\assets\IndexAsset;
use app\models\tables\Cottage;
use nirvana\showloading\ShowLoadingAsset;

IndexAsset::register($this);
ShowLoadingAsset::register($this);
$this->title = Yii::$app->name;

?>

<div class="col-sm-12 text-center">
    <button class="btn btn-success" id="addNewCottageBtn">Добавить участок в список</button>
</div>