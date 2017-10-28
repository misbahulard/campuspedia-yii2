<?php

namespace common\models;

use yii\db\ActiveRecord;

class EventLocation extends ActiveRecord
{
    public static function tableName()
    {
        return 'event_locations';
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

    public function getEvents()
    {
        return $this->hasMany(Event::className(), ['event_location_id' => 'event_location_id']);
    }
}
