<?php

use app\models\tables\Cottage;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $matrix Cottage */

$form = ActiveForm::begin(['id' => 'addCottage', 'options' => ['class' => 'form-horizontal bg-default'], 'enableAjaxValidation' => false, 'validateOnSubmit' => true, 'action' => ['/form/cottage-add']]);

echo $form->field($matrix, 'address', ['template' =>
    '<div class="col-sm-4">{label}</div><div class="col-sm-8">{input}{error}{hint}</div>'])
    ->textInput();
echo $form->field($matrix, 'square', ['template' =>
    '<div class="col-sm-4">{label}</div><div class="col-sm-8">{input}{error}{hint}</div>'])
    ->textInput();
echo $form->field($matrix, 'deposit', ['template' =>
    '<div class="col-sm-4">{label}</div><div class="col-sm-8">{input}{error}{hint}</div>'])
    ->textInput(['type' => 'number', 'step' => '0.01']);
echo $form->field($matrix, 'rights_data', ['template' =>
    '<div class="col-sm-4">{label}</div><div class="col-sm-8">{input}{error}{hint}</div>'])
    ->textInput();
echo $form->field($matrix, 'description', ['template' =>
    '<div class="col-sm-4">{label}</div><div class="col-sm-8">{input}{error}{hint}</div>'])
    ->textarea();

echo "<div class='clearfix'></div>";
echo Html::beginTag('div', ['class' => 'form-group text-center']);
echo Html::submitButton('<span class="text-success">Сохранить</span>', ['class' => 'btn btn-default']);
echo Html::endTag('div');
ActiveForm::end();
