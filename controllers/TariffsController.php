<?php


namespace app\controllers;


use app\models\tables\TariffPower;
use yii\filters\AccessControl;
use yii\web\Controller;

class TariffsController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'denyCallback' => function () {
                    return $this->redirect('/login', 301);
                },
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['fill'],
                        'roles' => ['writer'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionFill(): string
    {
        $month = new TariffPower(['scenario' => TariffPower::SCENARIO_FILL]);
        // открою страницу с возможностью заполнения тарифов
        return $this->render('fill', ['month' => $month]);
    }
}