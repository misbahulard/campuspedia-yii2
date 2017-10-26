<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

class MainCategory extends ActiveRecord
{
    public static function tableName()
    {
        return 'event_main_categories';
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
