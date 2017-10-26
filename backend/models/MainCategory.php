<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use backend\models\Category;

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
