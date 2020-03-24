<?php

use app\assets\SettingsAsset;
use app\models\Settings;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $settings Settings */

SettingsAsset::register($this);

$this->title = 'Настройки';
// тут будут вкладки с различными элементами управления системой
?>

<ul class="nav nav-tabs">
    <li id="settings_li" class="active"><a href="#settings" data-toggle="tab" class="active">Настройки</a></li>
    <li id="tools_li" ><a href="#tools" data-toggle="tab" class="active">Инструменты</a></li>
    <li id="patterns_li" ><a href="#patterns" data-toggle="tab" class="active">Шаблоны</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="settings">
        <?php
        // тут будут заполняемые настройки
        $form = ActiveForm::begin([
            'id' => 'settings-form',
            'options' => ['class' => 'form'],
            'enableAjaxValidation' => false,
            'validateOnSubmit' => true
        ]);
        echo '<h2 class="text-center margin-both">Настройки почты</h2>';
        echo $form->field($settings, 'mailAddress', ['template' =>
            '<div class="col-sm-4">{label}</div><div class="col-sm-8">{input}{error}{hint}</div>'])
            ->textInput()
            ->hint('Введите адрес почты, с коротого будет осуществляться отправка почты');

        echo $form->field($settings, 'mailLogin', ['template' =>
            '<div class="col-sm-4">{label}</div><div class="col-sm-8">{input}{error}{hint}</div>'])
            ->textInput()
            ->hint('Введите имя пользователя почты, с коротой будет осуществляться отправка почты');

        echo $form->field($settings, 'mailPassword', ['template' =>
            '<div class="col-sm-4">{label}</div><div class="col-sm-8">{input}{error}{hint}</div>'])
            ->passwordInput()
            ->hint('Введите пароль почты, с коротой будет осуществляться отправка почты');

        echo $form->field($settings, 'mailName', ['template' =>
            '<div class="col-sm-4">{label}</div><div class="col-sm-8">{input}{error}{hint}</div>'])
            ->textInput()
            ->hint('Введите название СНТ, которое будет отображаться в заголовке письма');

        echo $form->field($settings, 'mailIsTest', ['template' =>
            '<div class="col-sm-4">{label}</div><div class="col-sm-8">{input}{error}{hint}</div>'])
            ->checkbox()
            ->hint('Если активно- почта будет отправляться на указанный ниже адрес вместо отправки реальным получателям');

        echo $form->field($settings, 'mailTestAddress', ['template' =>
            '<div class="col-sm-4">{label}</div><div class="col-sm-8">{input}{error}{hint}</div>'])
            ->textInput()
            ->hint('Введите адрес почты, на который почта будет отправляться в тестовом режиме');

        echo '<h2 class="text-center margin-both">Банковские настройки</h2>';


        echo $form->field($settings, 'st', ['template' =>
            '<div class="col-sm-4">{label}</div><div class="col-sm-8">{input}{error}{hint}</div>'])
            ->textInput();

        echo $form->field($settings, 'sntName', ['template' =>
            '<div class="col-sm-4">{label}</div><div class="col-sm-8">{input}{error}{hint}</div>'])
            ->textInput();

        echo $form->field($settings, 'personalAcc', ['template' =>
            '<div class="col-sm-4">{label}</div><div class="col-sm-8">{input}{error}{hint}</div>'])
            ->textInput();

        echo $form->field($settings, 'bankName', ['template' =>
            '<div class="col-sm-4">{label}</div><div class="col-sm-8">{input}{error}{hint}</div>'])
            ->textInput();

        echo $form->field($settings, 'bik', ['template' =>
            '<div class="col-sm-4">{label}</div><div class="col-sm-8">{input}{error}{hint}</div>'])
            ->textInput();

        echo $form->field($settings, 'correspAcc', ['template' =>
            '<div class="col-sm-4">{label}</div><div class="col-sm-8">{input}{error}{hint}</div>'])
            ->textInput();

        echo $form->field($settings, 'payerInn', ['template' =>
            '<div class="col-sm-4">{label}</div><div class="col-sm-8">{input}{error}{hint}</div>'])
            ->textInput();

        echo $form->field($settings, 'kpp', ['template' =>
            '<div class="col-sm-4">{label}</div><div class="col-sm-8">{input}{error}{hint}</div>'])
            ->textInput();
        echo Html::beginTag('div', ['class' => 'col-sm-12 text-center']);
        echo Html::submitButton('<span class="text-success">Сохранить</span>', ['class' => 'btn btn-default']);
        echo Html::endTag('div');

        ActiveForm::end();
        ?>
    </div>
    <div class="tab-pane" id="tools">
        Тут инструменты
    </div>
    <div class="tab-pane" id="patterns">
        Тут шаблоны
    </div>
</div>
