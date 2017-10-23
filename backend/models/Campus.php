<?php

namespace backend\models;

use yii\db\ActiveRecord;
use backend\models\CampusLocation;

class Campus extends ActiveRecord
{
    public static function tableName()
    {
        return 'campuses';
    }

    public function getCampusLocation()
    {
        return $this->hasOne(CampusLocation::className(), ['campus_location_id' => 'campus_location_id']); 
    }
}
