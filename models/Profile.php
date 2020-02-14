<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "shop_profile".
 *
 * @property int $id 主键ID
 * @property string $truename 真实姓名
 * @property int $age 年龄
 * @property string $sex 性别:0保密,1男,2女
 * @property string $birthday
 * @property string $nickname 昵称
 * @property string $compony 公司
 * @property int $createtime 创建时间
 * @property int $userid 关联用户表的用户id
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shop_profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['age', 'createtime', 'userid'], 'integer'],
            [['sex'], 'string'],
            [['birthday'], 'safe'],
            [['truename', 'nickname'], 'string', 'max' => 32],
            [['compony'], 'string', 'max' => 100],
            [['userid'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'truename' => 'Truename',
            'age' => 'Age',
            'sex' => 'Sex',
            'birthday' => 'Birthday',
            'nickname' => 'Nickname',
            'compony' => 'Compony',
            'createtime' => 'Createtime',
            'userid' => 'Userid',
        ];
    }
}
