<?php

namespace app\controllers;

use app\models\SignupForm;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Html;
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
                'only' => ['logout', 'login', 'signup', 'refreshtime'],
                'rules' => [
                    [
                        'actions' => ['refreshtime', 'logout'],
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
                    'logout'      => ['post'],
                    'refreshtime' => ['post']
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
        return $this->render('index');
    }

    /**
     * About action.
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
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

        $registered = Yii::$app->getSession()->getFlash("registered");

        return $this->render('login', [
            'model'      => $model,
            'registered' => $registered
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

            Yii::$app->getSession()->setFlash('registered', true);
            Yii::$app->getSession()->set('login', $user->username);

            //Перенаправит на страницу авторизацию
            return $this->redirect(['login']);

        }

        return $this->render('signup', [
            'model' => $model,
        ]);

    }

    public function actionRefreshtime() {

        $user = clone Yii::$app->user->identity;

        $username = Html::encode($user->username);
        $time = (int) Yii::$app->request->post("ut_{$username}");

        if ($time > 0) {
            $user->time = $time;
            $user->save();
        }

    }

}
