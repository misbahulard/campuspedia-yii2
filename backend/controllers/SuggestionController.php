<?php

namespace backend\controllers;

use common\models\Campus;
use common\models\Category;
use common\models\Event;
use common\models\EventLocation;
use common\models\Province;
use Yii;
use yii\base\Model;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\UploadedFile;

class SuggestionController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'edit', 'delete', 'accept'],
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
        $query = Event::find()->where(['status' => 0]);

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count()
        ]);

        $events = $query->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->render('index', [
            'events' => $events,
            'pagination' => $pagination
        ]);
    }

    /**
     * Menampilkan detail event
     * @param $id | int | string
     * @return string view
     */
    public function actionView($id)
    {
        $event = Event::findOne(['event_id' => $id]);

        return $this->render('view', ['event' => $event]);
    }

    /**
     * Membuat event baru
     * @return string view
     */
    public function actionCreate()
    {
        $event = new Event();
        $eventLocation = new EventLocation();
        $categories = Category::find()
            ->select(['name'])
            ->indexBy('category_id')
            ->column();
        $campuses = Campus::find()
            ->select(['name'])
            ->indexBy('campus_id')
            ->column();
        $provinces = Province::find()
            ->select(['name'])
            ->indexBy('name')
            ->column();

        $postData = Yii::$app->request->post();
        if ($event->load($postData) && $eventLocation->load($postData) && Model::validateMultiple([$event, $eventLocation])) {
            if ($eventLocation->save()) {
                $event->event_location_id = $eventLocation->event_location_id;
                // Upload File
                $event->imageFile = UploadedFile::getInstance($event, 'imageFile');
                if ($event->upload()) {
                    if ($event->save()) {
                        Yii::$app->session->setFlash('success', 'Event has been added successfully');
                        return $this->redirect(Url::to(['/suggestion/index']));
                    }
                }
            } else {
                Yii::$app->session->setFlash('error', 'Failed to add new campus');
                return $this->redirect(Url::to(['/suggestion/create']));
            }
        } else {
            return $this->render('create', [
                'event' => $event,
                'eventLocation' => $eventLocation,
                'provinces' => $provinces,
                'campuses' => $campuses,
                'categories' => $categories
            ]);
        }
    }

    /**
     * Edit Event
     * @return string view
     */
    public function actionEdit($id)
    {
        $event = Event::findOne(['event_id' => $id]);
        $eventLocation = EventLocation::findOne(['event_location_id' => $event->event_location_id]);
        $categories = Category::find()
            ->select(['name'])
            ->indexBy('category_id')
            ->column();
        $campuses = Campus::find()
            ->select(['name'])
            ->indexBy('campus_id')
            ->column();
        $provinces = Province::find()
            ->select(['name'])
            ->indexBy('name')
            ->column();

        $postData = Yii::$app->request->post();
        if ($event->load($postData) && $eventLocation->load($postData) && Model::validateMultiple([$event, $eventLocation])) {
            if ($eventLocation->save()) {
                $event->event_location_id = $eventLocation->event_location_id;
                // Upload File
                $event->imageFile = UploadedFile::getInstance($event, 'imageFile');
                if ($event->uploadEdit()) {
                    if ($event->save()) {
                        Yii::$app->session->setFlash('success', 'Event has been edited successfully');
                        return $this->redirect(Url::to(['/suggestion/index']));
                    }
                }
            } else {
                Yii::$app->session->setFlash('error', 'Failed to edit event');
                return $this->redirect(Url::to(['/suggestion/edit']));
            }
        } else {
            return $this->render('edit', [
                'event' => $event,
                'eventLocation' => $eventLocation,
                'provinces' => $provinces,
                'campuses' => $campuses,
                'categories' => $categories
            ]);
        }
    }

    public function actionDelete($id)
    {
        $event = Event::findOne(['event_id' => $id]);
        if ($event) {
            if ($event->destroy()) {
                return $this->redirect(['index']);
            }
        }
    }

    /**
     * Menyetujui Saran Event
     * @return redirect to index
     */
    public function actionAccept($id)
    {
        $event = Event::findOne(['event_id' => $id]);
        $event->status = 1;
        if ($event->save()) {
            Yii::$app->session->setFlash('success', 'Accept event success');
            return $this->redirect(Url::to(['/suggestion/index']));
        } else {
            Yii::$app->session->setFlash('error', 'Accept event failed');
            return $this->redirect(Url::to(['/suggestion/index']));
        }
    }
}
