<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\LoginForm;
use backend\models\RegisterForm;

use backend\models\Campus;
use backend\models\Event;
use backend\models\User;

/**
 * Site controller for DASHBOARD
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'register', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $campusTotal = Campus::find()->count();
        $eventTotal = Event::find()->where(['status' => 1])->count();
        $suggestionTotal = Event::find()->where(['status' => 0])->count();
        $userTotal = User::find()->where(['role_id' => 2])->count();
        return $this->render('index', [
            'campusTotal' => $campusTotal,
            'eventTotal' => $eventTotal,
            'suggestionTotal' => $suggestionTotal,
            'userTotal' => $userTotal
        ]);
    }

    /**
     * Signs user up.
     * DISABLED
     * @return mixed
     */
    // public function actionRegister()
    // {
    //     $model = new RegisterForm();
    //     if ($model->load(Yii::$app->request->post())) {
    //         if ($user = $model->register()) {
    //             if (Yii::$app->getUser()->login($user)) {
    //                 return $this->goHome();
    //             }
    //         }
    //     }

    //     return $this->render('register', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = '//main-login';
        
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
