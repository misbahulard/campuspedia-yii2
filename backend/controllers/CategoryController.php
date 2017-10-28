<?php

namespace backend\controllers;

use common\models\Category;
use common\models\MainCategory;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

class CategoryController extends Controller
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
        $query = Category::find();

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
        $category = new Category();
        $mainCategories = MainCategory::find()
            ->select(['name'])
            ->indexBy('main_category_id')
            ->column();

        $postData = Yii::$app->request->post();
        if ($category->load($postData) && $category->validate()) {
            if ($category->save()) {
                Yii::$app->session->setFlash('success', 'category has been added successfully');
                return $this->redirect(Url::to(['/category/index']));
            } else {
                Yii::$app->session->setFlash('error', 'Failed to add new category');
                return $this->redirect(Url::to(['/category/create']));
            }
        } else {
            return $this->render('create', ['category' => $category, 'mainCategories' => $mainCategories]);
        }
    }

    /**
     * Mengubah kategory.
     *
     * @return string view
     */
    public function actionEdit($id)
    {
        $category = Category::findOne(['category_id' => $id]);
        $mainCategories = MainCategory::find()
            ->select(['name'])
            ->indexBy('main_category_id')
            ->column();

        $postData = Yii::$app->request->post();
        if ($category->load($postData) && $category->validate()) {
            if ($category->save()) {
                Yii::$app->session->setFlash('success', 'category has been edited successfully');
                return $this->redirect(Url::to(['/category/index']));
            } else {
                Yii::$app->session->setFlash('error', 'Failed to edit category');
                return $this->redirect(Url::to(['/category/create']));
            }
        } else {
            return $this->render('edit', ['category' => $category, 'mainCategories' => $mainCategories]);
        }
    }

    public function actionDelete($id)
    {
        $category = Category::findOne(['category_id' => $id]);
        if ($category->delete()) {
            Yii::$app->session->setFlash('success', 'Category has been deleted successfully');
            return $this->redirect(['index']);
        }
    }
}
