<?php

namespace app\controllers;

use app\exceptions\MyException;
use app\models\handlers\TariffsHandler;
use app\models\Settings;
use app\models\tables\Cottage;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\Response;

class SiteController extends Controller
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
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['settings'],
                        'roles' => ['writer'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    /**
     * Главная страница со списком участков
     * @return string|object
     * @throws MyException
     */
    public function actionIndex()
    {
        // проверю наличие тарифов
        if(!TariffsHandler::isTariffsFilled()){
            // если тарифы не заполнены- перенаправлю на страницу заполнения тарифов
            return $this->redirect('/tariffs/fill', 301);
        }
        // получу список участков
        $cottageList = Cottage::getOrderedCottages();
        return $this->render('index', ['cottageList' => $cottageList]);
    }

    /**
     * Страница управления
     * @return string|Response
     */
    public function actionSettings()
    {
        $settings = new Settings();
        if (Yii::$app->request->isPost) {
            // похоже, изменились настройки
            $settings->load(Yii::$app->request->post());
            if ($settings->validate()) {
                $settings->save();
                return $this->redirect(Url::toRoute('site/settings'), 301);
            }
        }
        $settings->fill();
        return $this->render('settings', ['settings' => $settings]);
    }
}
