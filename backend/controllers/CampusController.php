<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use backend\models\Campus;

class CampusController extends Controller
{
    /**
     * Displays index.
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = Campus::find();

        $pagination = new Pagination([
            'defaultPageSize' => 5, 
            'totalCount' => $query->count()
        ]);

        $campuses = $query->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->render('index', [
            'campuses' => $campuses,
            'pagination' => $pagination
        ]);
    }

    /**
     * Menampilkan detail kampus
     * @param $id | int | string
     * @return string view
     */
    public function actionView($id)
    {
        $campus = Campus::findOne(['campus_id' => $id]);

        return $this->render('view', ['campus' => $campus]);
    }
}
