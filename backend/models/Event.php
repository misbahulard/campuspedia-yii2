<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

class Event extends ActiveRecord
{
    public static function tableName()
    {
        return 'events';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
        ];
    }
}
