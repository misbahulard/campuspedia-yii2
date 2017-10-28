<?php

namespace common\models;

use yii\db\ActiveRecord;

class Reminder extends ActiveRecord
{
    public static function tableName()
    {
        return 'reminders';
    }
}
