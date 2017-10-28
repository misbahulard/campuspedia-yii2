<?php

namespace common\models;

use yii\db\ActiveRecord;

class CampusLocation extends ActiveRecord
{
    public static function tableName()
    {
        return 'campus_locations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['street_address', 'postal_code', 'city', 'state_province', 'latitude', 'longtitude'], 'required'],
            [['postal_code'], 'integer']
        ];
    }

    public function getCampuses()
    {
        return $this->hasMany(Campus::className(), ['campus_location_id' => 'campus_location_id']);
    }
}
