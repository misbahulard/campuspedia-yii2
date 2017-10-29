<?php

namespace api\controllers;


use api\models\MainCategory;
use Yii;
use yii\data\Pagination;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

class MainCategoryController extends Controller
{
    public function actionIndex()
    {
        $perPage = 20;
        $query = MainCategory::find();

        $pagination = new Pagination([
            'defaultPageSize' => $perPage,
            'totalCount' => $query->count()
        ]);

        $main_categories = $query->offset($pagination->offset)->limit($pagination->limit)->with('categories')->asArray()->all();

        $totalCount = intval($query->count());
        $pageCount = ceil($totalCount / $perPage);
        $currentPage = Yii::$app->request->get('page', 1);

        return [
            'data' => $main_categories,
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
        $main_category = MainCategory::findOne(['main_category_id' => $id]);

        if ($main_category == null) {
            throw new NotFoundHttpException('Main Category not found!');
        }

        return [
            'data' => [
                'main_category_id' => $main_category->main_category_id,
                'name' => $main_category->name,
                'category' => $main_category->categories
            ],
        ];
    }
}