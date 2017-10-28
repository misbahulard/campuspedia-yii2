<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

use backend\models\Category;
use backend\models\EventLocation;
use backend\models\Campus;

class Event extends ActiveRecord
{

    public $imageFile;

    public static function tableName()
    {
        return 'events';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'campus_id','name', 'description', 'event_date', 'status'], 'required'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * Fungsi untuk upload poster event yang membuat baru
     */
    public function upload()
    {
        if ($this->validate()) {
            if ($this->imageFile != null) {
                $newName = md5(time()) . '.' . $this->imageFile->extension;
                $this->imageFile->saveAs(Yii::getAlias('@frontend/web/img/events/' . $newName));
                $this->imageFile = null;
                $this->photo = $newName;    
            } else {
                $this->photo = 'default.jpg';
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Fungsi untuk upload poster event yang edit
     */
    public function uploadEdit()
    {
        if ($this->validate()) {
            if ($this->imageFile != null) {
                if ($this->photo != 'default.jpg') {
                    if(!unlink(Yii::getAlias('@frontend/web/img/events/' . $this->photo))) {
                        Yii::$app->session->setFlash('error', 'Failed to delete previous image');
                    }
                }
                $newName = md5(time()) . '.' . $this->imageFile->extension;
                $this->imageFile->saveAs(Yii::getAlias('@frontend/web/img/events/' . $newName));
                $this->imageFile = null;
                $this->photo = $newName;    
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Fungsi untuk menghapus event
     * Dan menghapus gambar poster event
     * @return boolean
     */
    public function destroy()
    {
        if ($this->photo != 'default.jpg') {
            if(unlink(Yii::getAlias('@frontend/web/img/events/' . $this->photo))) {
                if ($this->delete()) {  
                    Yii::$app->session->setFlash('success', 'event has been deleted');  
                    return true;
                } else {
                    Yii::$app->session->setFlash('error', 'Failed to delete event');
                    return false;
                }    
            } else {
                Yii::$app->session->setFlash('error', 'Failed to delete image');
                return false;
            }
        } else {
            if ($this->delete()) {  
                Yii::$app->session->setFlash('success', 'event has been deleted');  
                return true;
            } else {
                Yii::$app->session->setFlash('error', 'Failed to delete event');
                return false;
            }
        }
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['category_id' => 'category_id']);
    }

    public function getEventLocation()
    {
        return $this->hasOne(EventLocation::className(), ['event_location_id' => 'event_location_id']); 
    }

    public function getCampus()
    {
        return $this->hasOne(Campus::className(), ['campus_id' => 'campus_id']);
    }
}
