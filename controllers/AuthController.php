<?php


namespace app\controllers;


use app\models\auth\AuthForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ErrorAction;

class AuthController extends Controller
{

    public $layout = 'auth';


    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::class,
                'denyCallback' => function(){
                    return $this->redirect('/', 301);
                },
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actions(){
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    public function actionLogin(){
        $auth = new AuthForm(['scenario' => AuthForm::SCENARIO_LOGIN]);
        /** @noinspection NotOptimalIfConditionsInspection */
        if(Yii::$app->request->isPost && $auth->load(Yii::$app->request->post()) && $auth->validate() && $auth->login()){
            return $this->goHome();
        }
        return $this->render('login', [
            'auth' => $auth,
        ]);
    }

}