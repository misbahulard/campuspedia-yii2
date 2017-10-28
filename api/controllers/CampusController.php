<?php

namespace api\controllers;

use api\models\Campus;
use Yii;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\rest\Controller;

class CampusController extends Controller
{
    public $img_path = "http://campuspedia.madamita.ml/img/";

    public function actionIndex()
    {
        $perPage = 20;
        $query = Campus::find();

        $pagination = new Pagination([
            'defaultPageSize' => $perPage,
            'totalCount' => $query->count()
        ]);

        $campuses = $query->offset($pagination->offset)->limit($pagination->limit)->with('campusLocation')->asArray()->all();

        $totalCount = intval($query->count());
        $pageCount = ceil($totalCount / $perPage);
        $currentPage = Yii::$app->request->get('page', 1);

        return [
            'data' => $campuses,
            'logo_path' => $this->img_path,
            'meta' => [
                'totalCount' => $totalCount,
                'pageCount' => $pageCount,
                'currentPage' => $currentPage,
                'perPage' => $perPage
            ]
        ];
    }
//    public $modelClass = 'api\models\Campus';
//
//    public $serializer = [
//        'class' => 'yii\rest\Serializer',
//        'collectionEnvelope' => 'data',
//    ];

//    public function actions()
//    {
//        $actions = parent::actions();
////        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
//        return $actions;
//    }
//
//    public function prepareDataProvider()
//    {
//        $query = Campus::find();
//
//        $pagination = new Pagination([
//            'defaultPageSize' => 5,
//            'totalCount' => $query->count()
//        ]);
//
//        $campuses = $query->offset($pagination->offset)->limit($pagination->limit)->with('campusLocation')->asArray()->all();
//
//        return [
//            'data' => $campuses,
//            'success' => true
//            ];
//    }

}