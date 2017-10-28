<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

class Reminder extends ActiveRecord
{
    public static function tableName()
    {
        return 'reminders';
    }
}
