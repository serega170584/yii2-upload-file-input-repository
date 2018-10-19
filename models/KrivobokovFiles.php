<?php

namespace serega170584\file\models;

use Yii;

/**
 * This is the model class for table "{{%krivobokov_files}}".
 *
 * @property int $id
 * @property string $name
 * @property string $directory
 * @property string $extension
 * @property string $type
 * @property int $size
 */
class KrivobokovFiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%krivobokov_files}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'directory', 'extension', 'type'], 'string', 'max' => 255],
            ['size', 'integer']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'directory' => Yii::t('app', 'Directory'),
            'extension' => Yii::t('app', 'Extension'),
        ];
    }
}
