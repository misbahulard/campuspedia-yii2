<?php

namespace backend\controllers;

use Yii;
use yii\base\Model;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\Controller;

use backend\models\MainCategory;

class MainCategoryController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'edit', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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
    
    public function actionIndex()
    {
        $query = MainCategory::find();
        
        $pagination = new Pagination([
            'defaultPageSize' => 5, 
            'totalCount' => $query->count()
        ]);

        $categories = $query->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->render('index', [
            'categories' => $categories,
            'pagination' => $pagination
        ]);
    }
}
