<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

class Province extends ActiveRecord
{
    public static function tableName()
    {
        return 'provinces';
    }
}
