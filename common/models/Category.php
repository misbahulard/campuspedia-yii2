<?php

namespace common\models;

use yii\db\ActiveRecord;

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
