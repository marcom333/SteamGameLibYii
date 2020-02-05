<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "folder".
 *
 * @property int $id
 * @property int|null $folder_id
 * @property string|null $name
 * @property int|null $user_id
 */
class Folder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'folder';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['folder_id', 'user_id'], 'integer'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'folder_id' => 'Folder ID',
            'name' => 'Name',
            'user_id' => 'User ID',
        ];
    }


    public function getParent(){
        $parent = Folder::findOne(["id"=>$this->folder_id]);
        if($parent){
            return $parent;
        }
        else{
            return new class {
                public $name;
                public function __construct(){
                    $this->name = "Root";
                }
            };
        }
    }
}
