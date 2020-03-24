<?php


namespace app\controllers;


use app\models\tables\Cottage;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class FormController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'denyCallback' => static function () {
                    echo 'error!';
                    die;
                },
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['cottage-add'],
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
     * @throws NotFoundHttpException
     */
    public function actionCottageAdd(): array
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isGet) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $form = new Cottage(['scenario' => Cottage::SCENARIO_CREATE]);
            $view = $this->renderAjax('add-cottage', ['matrix' => $form]);
            return ['status' => 1,
                'header' => 'Добавление участка',
                'data' => $view,
            ];
        }
        throw new NotFoundHttpException();
    }
}