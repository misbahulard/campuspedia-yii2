<?php

namespace api\controllers;


use api\models\Category;
use Yii;
use yii\data\Pagination;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

class CategoryController extends Controller
{
    public function actionIndex()
    {
        $perPage = 20;
        $query = Category::find();

        $pagination = new Pagination([
            'defaultPageSize' => $perPage,
            'totalCount' => $query->count()
        ]);

        $categories = $query->offset($pagination->offset)->limit($pagination->limit)->all();

        $totalCount = intval($query->count());
        $pageCount = ceil($totalCount / $perPage);
        $currentPage = Yii::$app->request->get('page', 1);

        return [
            'data' => $categories,
            'meta' => [
                'totalCount' => $totalCount,
                'pageCount' => $pageCount,
                'currentPage' => $currentPage,
                'perPage' => $perPage
            ]
        ];
    }

    /**
     * menampilkan daftar category yang memiliki id main_category yang sama
     *
     * @param $id adalah id dari main_category bukan id category
     * @return array
     */
    public function actionView($id)
    {
        $category = Category::find()->where(['main_category_id' => $id])->all();

        if ($category == null) {
            throw new NotFoundHttpException('Category not found!');
        }

        return [
            'data' => $category
        ];
    }
}