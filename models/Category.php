<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "shop_category".
 *
 * @property int $cateid 主键id
 * @property string $title 分类名称
 * @property int $parentid 父类id
 * @property int $createtime 创建时间
 */
class Category extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shop_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parentid', 'createtime'], 'integer'],
            [['title'], 'string', 'max' => 64],
            ['title','unique','message'=>'分类已经存在'],
            ['createtime','safe'],
            ['parentid','check','on'=>'mod']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cateid' => '分类ID',
            'title' => '分类名称',
            'parentid' => '父类ID',
            'createtime' => '创建时间',
        ];
    }

    public function check(){
        if(!$this->hasErrors()){
            if($this->cateid == $this->parentid){
                $this->addError('parentid','分类不符合标准,不能选择当前操作的分类作为父类');
            }
        }
    }

    /**
     * 添加分类
     */
    public function add($data){
        if($this->load($data) && $this->save()){
            return true;
        }
        return false;
    }

    /**
     * 获取无限分类数据
     * @return array
     */
    public function getCates(){
        $cates = self::find()->asArray()->all(); // 将查询的所有分类转换为数组格式.
        $tree = self::getTree($cates);
        return array_merge([['cateid'=>0,'title'=>'添加顶级分类']],$tree);

    }

    /**
     * 无限分类
     * @param $cates
     * @param string $pid
     * @param int $level
     * @return array
     */
    public function getTree($cates,$pid='0',$level=0){
        $tree = [];
        foreach($cates as $cate){
            if($cate['parentid']==$pid){
                $cate['level'] = $level;
                $cate['title'] = str_repeat('|------',$level).$cate['title'];
                $tree[] = $cate;
                $tree = array_merge($tree,self::getTree($cates,$cate['cateid'],$level+1));
            }
        }
        return $tree;
    }

    /**
     * 获取分类信息,转换为dropdownlist使用的数组格式 ['cateid' => 'title' ]
     * @return array
     */
    public static function getList(){
        $cates = self::getCates();
        $list = [];
        foreach($cates as $cate){
            if($cate['cateid']!= 0){
                $list[$cate['cateid']] = $cate['title'];
            }
        }
        return $list;
    }

    public function beforeSave($insert){
        if(parent::beforeSave($insert)){
            if($insert){
                $this->createtime = time();
            }
            return true;
        }
        return false;
    }



}
