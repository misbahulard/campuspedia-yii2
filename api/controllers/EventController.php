<?php
/**
 * Created by PhpStorm.
 * User: misbahulard
 * Date: 10/29/2017
 * Time: 10:33 AM
 */

namespace api\controllers;


use api\models\Event;
use Yii;
use yii\data\Pagination;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

class EventController extends Controller
{
    public $img_path = "http://campuspedia.madamita.ml/img/events/";

    public function actionIndex()
    {
        $perPage = 20;
        $query = Event::find();

        $pagination = new Pagination([
            'defaultPageSize' => $perPage,
            'totalCount' => $query->count()
        ]);

        $events = $query->offset($pagination->offset)->limit($pagination->limit)
            ->with('category')
            ->with('eventLocation')
            ->with('campus')
            ->asArray()->all();

        $totalCount = intval($query->count());
        $pageCount = ceil($totalCount / $perPage);
        $currentPage = Yii::$app->request->get('page', 1);

        return [
            'data' => $events,
            'poster_path' => $this->img_path,
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
        $event = Event::find()
            ->where(['event_id' => $id])
            ->with('category')
            ->with('eventLocation')
            ->with('campus')
            ->asArray()
            ->one();

        if ($event == null) {
            throw new NotFoundHttpException('Event not found!');
        }

        return [
            'data' => $event,
            'poster_path' => $this->img_path,
        ];
    }

    public function actionByCategory($id)
    {
        $perPage = 20;
        $query = Event::find()->where(['category_id' => $id]);

        if ($query->all() == null) {
            throw new NotFoundHttpException('Event not found!');
        }

        $pagination = new Pagination([
            'defaultPageSize' => $perPage,
            'totalCount' => $query->count()
        ]);

        $events = $query->offset($pagination->offset)->limit($pagination->limit)
            ->with('category')
            ->with('eventLocation')
            ->with('campus')
            ->asArray()->all();

        $totalCount = intval($query->count());
        $pageCount = ceil($totalCount / $perPage);
        $currentPage = Yii::$app->request->get('page', 1);

        return [
            'data' => $events,
            'poster_path' => $this->img_path,
            'meta' => [
                'totalCount' => $totalCount,
                'pageCount' => $pageCount,
                'currentPage' => $currentPage,
                'perPage' => $perPage
            ]
        ];
    }
}