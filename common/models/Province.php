<?php

namespace common\models;

use yii\db\ActiveRecord;

class Province extends ActiveRecord
{
    public static function tableName()
    {
        return 'provinces';
    }
}
