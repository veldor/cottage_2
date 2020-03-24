<?php

/* @var $this View */

/* @var $content string */

use app\widgets\Alert;
use yii\bootstrap\Nav;
use yii\helpers\Html;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Breadcrumbs;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Html::img('@web/graphic/squareIcon.png', ['alt'=>Yii::$app->name, 'class' => 'brandImage']),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    try {
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                '<li><div id="goToCottageContainer"><label class="hidden" for="goToCottageInput"></label><div class="input-group">
                    <span class="input-group-btn">
                        <a class="btn btn-default" href="' . Url::toRoute('/cottage/previous') . '">
                            <span class="glyphicon glyphicon-backward"></span>
                        </a>
                    </span>
                     <input
                    type="text"
                    id="goToCottageInput"
                    class="form-control">
                    <span
                    class="input-group-btn"><a class="btn btn-default" href="' . Url::toRoute('/cottage/next') . '"><span
                            class="glyphicon glyphicon-forward"></span></a></span>
        </div></div></li>',
                ['label' => 'Статистика', 'url' => ['/count/index'], 'options' => ['class' => 'visible-lg']],
                ['label' => 'Выборки', 'url' => ['/search/search'], 'options' => ['class' => 'visible-lg']],
                ['label' => 'Заполнение', 'url' => ['/filling'], 'options' => ['class' => 'visible-lg']],
                ['label' => 'Тарифы', 'url' => ['/tariffs/index'], 'options' => ['class' => 'visible-lg']],
                ['label' => 'Управление', 'url' => ['' . Url::toRoute('site/settings') . ''], 'options' => ['class' => 'visible-lg']],
                ['label' => 'С', 'url' => ['/count/index'], 'options' => ['class' => 'hidden-lg hidden-xs', 'title' => 'Статистика']],
                ['label' => 'В', 'url' => ['/search/search'], 'options' => ['class' => 'hidden-lg hidden-xs', 'title' => 'Выборки']],
                ['label' => 'З', 'url' => ['/filling'], 'options' => ['class' => 'hidden-lg hidden-xs', 'title' => 'Заполнение']],
                ['label' => 'Т', 'url' => ['/tariffs/index'], 'options' => ['class' => 'hidden-lg hidden-xs', 'title' => 'Тарифы']],
                ['label' => 'У', 'url' => ['' . Url::toRoute('site/settings') . ''], 'options' => ['class' => 'hidden-lg hidden-xs', 'title' => 'Управление']],
                ['label' => 'Статистика', 'url' => ['/count/index'], 'options' => ['class' => 'visible-xs']],
                ['label' => 'Выборки', 'url' => ['/search/search'], 'options' => ['class' => 'visible-xs']],
                ['label' => 'Заполнение', 'url' => ['/filling/power'], 'options' => ['class' => 'visible-xs']],
                ['label' => 'Тарифы', 'url' => ['/tariffs/index'], 'options' => ['class' => 'visible-xs']],
                ['label' => 'Управление', 'url' => ['/management/index'], 'options' => ['class' => 'visible-xs']],
                //            ['label' => 'Шаблоны', 'url' => ['/template/show']],
                //            ['label' => 'Панель управления', 'url' => ['/person/management'], 'visible' =>\Yii::$app->user->can('manage')],
                /*                '<li class="hidden-sm">' . Html::beginForm(['/logout'], 'post') . Html::submitButton('Выйти: (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link logout']) . Html::endForm() . '</li>',*/
            ],
        ]);
    } catch (Exception $e) {
    }
    //echo ;
    NavBar::end();
    ?>

    <div class="container">
        <?php
        try {
            echo Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                'homeLink' => false,
            ]);
        } catch (Exception $e) {
        }
        try {
            echo Alert::widget();
        } catch (Exception $e) {
        }
        echo $content;
        ?>
    </div>
</div>
<div id="alertsContentDiv" class="no-print"></div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
