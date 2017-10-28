<?php

namespace backend\controllers;

use common\models\Campus;
use common\models\CampusLocation;
use common\models\Province;
use Yii;
use yii\base\Model;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\UploadedFile;

class CampusController extends Controller
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

    /**
     * Membuat kampus baru
     * @return string view
     */
    public function actionCreate()
    {
        $campus = new Campus();
        $campusLocation = new CampusLocation();
        $provinces = Province::find()
            ->select(['name'])
            ->indexBy('name')
            ->column();

        $postData = Yii::$app->request->post();
        if ($campus->load($postData) && $campusLocation->load($postData) && Model::validateMultiple([$campus, $campusLocation])) {
            if ($campusLocation->save()) {
                $campus->campus_location_id = $campusLocation->campus_location_id;
                // Upload File
                $campus->imageFile = UploadedFile::getInstance($campus, 'imageFile');
                if ($campus->upload()) {
                    if ($campus->save()) {
                        Yii::$app->session->setFlash('success', 'Campus has been added successfully');
                        return $this->redirect(Url::to(['/campus/index']));
                    }
                }
            } else {
                Yii::$app->session->setFlash('error', 'Failed to add new campus');
                return $this->redirect(Url::to(['/campus/create']));
            }
        } else {
            return $this->render('create', ['campus' => $campus, 'campusLocation' => $campusLocation, 'provinces' => $provinces]);
        }
    }

    /**
     * Edit kampus
     * @return string view
     */
    public function actionEdit($id)
    {
        $campus = Campus::findOne(['campus_id' => $id]);
        $campusLocation = CampusLocation::findOne(['campus_location_id' => $campus->campus_location_id]);
        $provinces = Province::find()
            ->select(['name'])
            ->indexBy('name')
            ->column();

        $postData = Yii::$app->request->post();
        if ($campus->load($postData) && $campusLocation->load($postData) && Model::validateMultiple([$campus, $campusLocation])) {
            if ($campusLocation->save()) {
                $campus->campus_location_id = $campusLocation->campus_location_id;
                // Upload File
                $campus->imageFile = UploadedFile::getInstance($campus, 'imageFile');
                if ($campus->uploadEdit()) {
                    if ($campus->save()) {
                        Yii::$app->session->setFlash('success', 'Campus has been edited successfully');
                        return $this->redirect(Url::to(['/campus/index']));
                    }
                }
            } else {
                Yii::$app->session->setFlash('error', 'Failed to edit campus');
                return $this->redirect(Url::to(['/campus/edit']));
            }
        } else {
            return $this->render('edit', ['campus' => $campus, 'campusLocation' => $campusLocation, 'provinces' => $provinces]);
        }
    }

    public function actionDelete($id)
    {
        $campus = Campus::findOne(['campus_id' => $id]);
        if ($campus) {
            if ($campus->destroy()) {
                return $this->redirect(['index']);
            }
        }
    }
}
