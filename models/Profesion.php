<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profesion".
 *
 * @property integer $id
 * @property string $profesion
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 *
 * @property Persona[] $personas
 */
class Profesion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profesion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //['profesion', 'filter', 'filter' => 'stroupper'],
            ['profesion', 'trim'],
            [['profesion', 'created_by'], 'required', 'message' => 'por favor complete este campo'],
            ['profesion', 'unique'],
            [['created_by', 'updated_by'], 'integer'],
            //['profesion', 'string', 'max' => 3],
            //['profesion', 'url', 'defaultScheme' => 'http', 'message' => 'URL inválida'],
            ['created_at', 'required', 'on' => 'actualizar'],
            [
                'created_at',
                'compare',
                'compareAttribute'  => 'profesion',
                'operator'  => '!=',
                'when'  => function($model) {
                    return $model->profesion != "Ingeniero Civil";
                },
                'whenClient'    => "function(attribute, value) {
                    return $('#profesion-profesion').val() != 'Ingeniero Civil';
                }"
            ],
            /*
            [
                'profesion', function($attribute, $params) {
                    if ( $this->$attribute != "Ingeniero Civil" ) {
                        $this->addError($attribute, "Esta profesión no está permitida");
                    }
                }
            ],
            */
            [['profesion', 'created_by'], 'profesionpermitida'],
        ];
    }
    /*
    public function profesionpermitida()
    {
        if ($this->profesion != "Ingeniero Civil") {
            $this->addError("profesion", "Esta profesión no está permitida");
        }
    }
    */
    
    public function profesionpermitida($attribute, $params)
    {
        if ( $this->$attribute != "Ingeniero Civil" ) {
            $this->addError($attribute, "Esta profesión no está permitida");
        }
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'profesion' => 'Profesion',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonas()
    {
        return $this->hasMany(Persona::className(), ['profesion_id' => 'id']);
    }
}
