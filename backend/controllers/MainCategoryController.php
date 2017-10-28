<?php

namespace backend\controllers;

use common\models\MainCategory;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

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

    /**
     * Menampilkan index.
     *
     * @return string view
     */
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

    /**
     * Membuat kategory baru.
     *
     * @return string view
     */
    public function actionCreate()
    {
        $category = new MainCategory();

        $postData = Yii::$app->request->post();
        if ($category->load($postData) && $category->validate()) {
            if ($category->save()) {
                Yii::$app->session->setFlash('success', 'category has been added successfully');
                return $this->redirect(Url::to(['/main-category/index']));
            } else {
                Yii::$app->session->setFlash('error', 'Failed to add new category');
                return $this->redirect(Url::to(['/main-category/create']));
            }
        } else {
            return $this->render('create', ['category' => $category]);
        }
    }

    /**
     * Mengubah kategory.
     *
     * @return string view
     */
    public function actionEdit($id)
    {
        $category = MainCategory::findOne(['main_category_id' => $id]);

        $postData = Yii::$app->request->post();
        if ($category->load($postData) && $category->validate()) {
            if ($category->save()) {
                Yii::$app->session->setFlash('success', 'category has been edited successfully');
                return $this->redirect(Url::to(['/main-category/index']));
            } else {
                Yii::$app->session->setFlash('error', 'Failed to edit category');
                return $this->redirect(Url::to(['/main-category/create']));
            }
        } else {
            return $this->render('edit', ['category' => $category]);
        }
    }

    public function actionDelete($id)
    {
        $category = MainCategory::findOne(['main_category_id' => $id]);
        if ($category->delete()) {
            Yii::$app->session->setFlash('success', 'Category has been deleted successfully');
            return $this->redirect(['index']);
        }
    }
}
