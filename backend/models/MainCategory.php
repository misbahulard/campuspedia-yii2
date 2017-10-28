<?php

namespace backend\models;

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

    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['main_category_id' => 'main_category_id']);
    }
}
