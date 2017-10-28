<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use backend\models\MainCategory;

class Category extends ActiveRecord
{
    public static function tableName()
    {
        return 'event_categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'main_category_id'], 'required'],
        ];
    }

    public function getMainCategory()
    {
        return $this->hasOne(MainCategory::className(), ['main_category_id' => 'main_category_id']); 
    }
}
