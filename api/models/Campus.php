<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use backend\models\CampusLocation;

class Campus extends ActiveRecord
{

    public $imageFile;

    public static function tableName()
    {
        return 'campuses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'web'], 'required'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * Fungsi untuk upload logo kampus yang membuat baru
     */
    public function upload()
    {
        if ($this->validate()) {
            if ($this->imageFile != null) {
                $newName = md5(time()) . '.' . $this->imageFile->extension;
                $this->imageFile->saveAs('img/campuses/' . $newName);
                $this->imageFile = null;
                $this->logo = $newName;    
            } else {
                $this->logo = 'default.jpg';
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Fungsi untuk upload logo kampus yang edit
     */
    public function uploadEdit()
    {
        if ($this->validate()) {
            if ($this->imageFile != null) {
                if(!unlink(Yii::getAlias('@app/web/img/campuses/' . $this->logo))) {
                    Yii::$app->session->setFlash('error', 'Failed to delete previous image');
                }
                $newName = md5(time()) . '.' . $this->imageFile->extension;
                $this->imageFile->saveAs('img/campuses/' . $newName);
                $this->imageFile = null;
                $this->logo = $newName;    
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Fungsi untuk menghapus campus
     * Dan menghapus gambar logo kampus
     * @return boolean
     */
    public function destroy()
    {
        if ($this->logo != 'default.jpg') {
            if(unlink(Yii::getAlias('@app/web/img/campuses/' . $this->logo))) {
                if ($this->delete()) {  
                    Yii::$app->session->setFlash('success', 'Campus has been deleted');  
                    return true;
                } else {
                    Yii::$app->session->setFlash('error', 'Failed to delete campus');
                    return false;
                }    
            } else {
                Yii::$app->session->setFlash('error', 'Failed to delete image');
                return false;
            }
        } else {
            if ($this->delete()) {  
                Yii::$app->session->setFlash('success', 'Campus has been deleted');  
                return true;
            } else {
                Yii::$app->session->setFlash('error', 'Failed to delete campus');
                return false;
            }
        }
    }

    public function getCampusLocation()
    {
        return $this->hasOne(CampusLocation::className(), ['campus_location_id' => 'campus_location_id']); 
    }
}
