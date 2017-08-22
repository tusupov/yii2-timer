<?php

namespace app\controllers;

use app\models\SignupForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{

    /**
     * Behaviors
     * @return array
     */
    public function behaviors()
    {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'login', 'signup'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login', 'signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];

    }

    /**
     * Actions
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     * @return string
     */
    public function actionIndex()
    {

        //Если не авторизирован перенаправить на страницу войти
        if (Yii::$app->user->isGuest)
            return $this->redirect(['login']);

        return $this->render('index');

    }

    /**
     * Login action.
     * @return Response|string
     */
    public function actionLogin()
    {

        $model = new LoginForm();

        //Если успешно авторизирован, перенаправить на главную
        if ($model->load(Yii::$app->request->post()) && $model->login())
            return $this->goHome();

        return $this->render('login', [
            'model' => $model,
        ]);

    }

    /**
     * Logout action.
     * @return Response
     */
    public function actionLogout()
    {

        Yii::$app->user->logout();
        return $this->goHome();

    }

    /**
     * Logout action.
     * @return Response
     */
    public function actionSignup() {

        $model = new SignupForm();

        //Успешно зарегистрирован
        if ($model->load(Yii::$app->request->post()) && $user = $model->signup()) {

            Yii::$app->getSession()->setFlash("registered", true);
            Yii::$app->getSession()->set("login", $user->username);

            //Перенаправит на страницу авторизацию
            return $this->redirect(['login']);

        }

        return $this->render("signup", [
            "model" => $model,
        ]);

    }

}
