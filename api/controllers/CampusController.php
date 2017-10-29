<?php

namespace api\controllers;

use api\models\Campus;
use Yii;
use yii\data\Pagination;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

class CampusController extends Controller
{
    public $img_path = "http://campuspedia.madamita.ml/img/campuses/";

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

    public function actionView($id)
    {
        $campus = Campus::findOne(['campus_id' => $id]);

        if ($campus == null) {
            throw new NotFoundHttpException('Campus not found!');
        }

        return [
            'data' => [
                'campus_id' => $campus->campus_id,
                'name' => $campus->name,
                'web' => $campus->web,
                'logo' => $this->img_path . $campus->logo,
                'location' => $campus->campusLocation
            ],
        ];
    }
}
