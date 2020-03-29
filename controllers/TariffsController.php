<?php


namespace app\controllers;


use app\models\tables\TariffPower;
use app\models\tariffs\TariffsFill;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

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
     * @return string|array
     */
    public function actionFill()
    {
        $form = new TariffsFill();
        if(Yii::$app->request->isAjax && Yii::$app->request->isPost){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $form->load(Yii::$app->request->post());
            return ActiveForm::validate($form);
        }
        if(Yii::$app->request->isPost){
            // сохраню пришедшие данные
            $form->load(Yii::$app->request->post());
            if($form->validate()){
                $form->save();
                return $this->redirect(Url::toRoute('tariffs/fill'), 301);
            }
        }
        // открою страницу с возможностью заполнения тарифов
        return $this->render('fill', ['model' => $form]);
    }
}