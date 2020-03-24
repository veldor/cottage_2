<?php
use app\assets\AuthAsset;
use app\models\auth\AuthForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $auth AuthForm */

AuthAsset::register($this);

$this->title = 'Облепиха, вход';

?>
<div class="site-login text-center">
    <div id="ourLogo" class="visible-sm visible-md visible-lg"></div>
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'fieldConfig' => [
            'labelOptions' => ['class' => 'control-label'],
        ],
    ]); ?>
    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($auth, 'name')->textInput(['autofocus' => true])->label('Имя пользователя') ?>

            <?= $form->field($auth, 'password')->passwordInput()->label('Пароль') ?>

            <?= $form->field($auth, 'rememberMe')->checkbox()->hint('Если активно, вам не придётся вводить данные заново при каждом визите.') ?>

            <div class="form-group">
                <?= Html::submitButton('Вход', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

      <?php ActiveForm::end(); ?>

</div>
