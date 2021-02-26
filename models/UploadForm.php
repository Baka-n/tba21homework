<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $csvFile;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['csvFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv', 'checkExtensionByMimeType' => false],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'csvFile' => 'Upload',
        ];
    }

    /**
     * Validates file
     * @return bool
     */
    public function process()
    {
        if($this->validate()) {
            return true;
        } else {
            return false;
        }
    }
}