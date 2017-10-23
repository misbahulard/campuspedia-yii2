<?php

namespace backend\models;

use yii\db\ActiveRecord;
use backend\models\Campus;

class CampusLocation extends ActiveRecord
{
    public static function tableName()
    {
        return 'campus_locations';
    }

    public function getCampuses()
    {
        return $this->hasMany(Campus::className(), ['campus_location_id' => 'campus_location_id']);
    }
}
