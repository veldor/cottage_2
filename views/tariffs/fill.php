<?php

use app\assets\TariffsAsset;
use app\models\tariffs\TariffsFill;
use kartik\date\DatePicker;
use unclead\multipleinput\MultipleInput;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model TariffsFill */

TariffsAsset::register($this);

$this->title = 'Заполнение тарифов';

echo '<h1 class="text-center">Добавление тарифов</h1>';

$form = ActiveForm::begin(['id' => 'fillTariffs', 'options' => ['class' => 'form-horizontal bg-default'], 'enableAjaxValidation' => true, 'validateOnSubmit' => true, 'action' => ['/tariffs/fill']]);
// создам форму
try {
    echo $form->field($model, 'power')->widget(MultipleInput::class, [
        'min' => 0,
        'max' => 50,
        'enableError' => true,
        'cloneButton' => true,
        'columns' => [
            [
                'name' => 'month',
                'enableError' => true,
                'type' => DatePicker::class,
                'title' => 'Месяц оплаты',
                'options' => [
                    'options' => ['placeholder' => 'Месяц оплаты'],
                    'pluginOptions' => [
                        'minViewMode' => 'months',
                        'format' => 'yyyy-mm',
                        'autoclose' => true,
                    ]
                ]
            ],
            [
                'name' => 'limit',
                'enableError' => true,
                'title' => 'Лимит потребления',
                'options' => [
                    'placeholder' => 'Лимит потребления',
                    'type' => 'number',
                    'step' => '1'
                ]
            ],
            [
                'name' => 'cost',
                'title' => 'Льготная цена',
                'options' => [
                    'placeholder' => 'Льготная цена',
                    'type' => 'number',
                    'step' => '0.01'
                ]
            ],
            [
                'name' => 'overCost',
                'title' => 'Обычная цена',
                'options' => [
                    'placeholder' => 'Обычная цена',
                    'type' => 'number',
                    'step' => '0.01'
                ]
            ],
        ]
    ])
    ->label('Элекроэнергия');

    echo $form->field($model, 'membership')->widget(MultipleInput::class, [
        'min' => 0,
        'max' => 50,
        'cloneButton' => true,
        'columns' => [
            [
                'name' => 'quarter',
                'type' => DatePicker::class,
                'title' => 'Квартал',
                'options' => [
                    'options' => ['placeholder' => 'Выберите месяц, входящий в квартал'],
                    'pluginOptions' => [
                        'minViewMode' => 'months',
                        'format' => 'yyyy-mm',
                        'autoclose' => true,
                    ]
                ]
            ],
            [
                'name' => 'fixed',
                'title' => 'Оплата с участка',
                'options' => [
                    'placeholder' => 'Оплата с участка',
                    'type' => 'number',
                    'step' => '0.01'
                ]
            ],
            [
                'name' => 'float',
                'title' => 'Оплата с сотки',
                'options' => [
                    'placeholder' => 'Оплата с сотки',
                    'type' => 'number',
                    'step' => '0.01'
                ]
            ],
        ]
    ])
    ->label('Членские взносы');

    echo $form->field($model, 'target')->widget(MultipleInput::class, [
        'min' => 0,
        'max' => 50,
        'cloneButton' => true,
        'columns' => [
            [
                'name' => 'year',
                'type' => DatePicker::class,
                'title' => 'Год',
                'options' => [
                    'options' => ['placeholder' => 'Выберите год'],
                    'pluginOptions' => [
                        'minViewMode' => 'years',
                        'format' => 'yyyy',
                        'autoclose' => true,
                    ]
                ]
            ],
            [
                'name' => 'fixed',
                'title' => 'Оплата с участка',
                'options' => [
                    'placeholder' => 'Оплата с участка',
                    'type' => 'number',
                    'step' => '0.01'
                ]
            ],
            [
                'name' => 'float',
                'title' => 'Оплата с сотки',
                'options' => [
                    'placeholder' => 'Оплата с сотки',
                    'type' => 'number',
                    'step' => '0.01'
                ]
            ],
            [
                'name' => 'destination',
                'type' => 'textarea',
                'value' => 'назначение взноса'
            ],
        ]
    ])
    ->label('Членские взносы');
} catch (Exception $e) {
    echo $e->getMessage();
    die;
}

echo Html::beginTag('div', ['class' => 'form-group text-center']);
echo Html::submitButton('<span class="text-success">Добавить тарифы</span>', ['class' => 'btn btn-default']);
echo Html::endTag('div');

ActiveForm::end();