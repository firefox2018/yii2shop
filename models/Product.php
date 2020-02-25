<?php

namespace app\models;

use Yii;
use app\models\Category;

/**
 * This is the model class for table "shop_product".
 *
 * @property int $productid 商品id
 * @property int $cateid 分类id
 * @property string $title 商品名称
 * @property string|null $description 商品描述
 * @property int $num 商品数量
 * @property float $price
 * @property string $cover 封面图
 * @property string|null $pics
 * @property string $issale 商品状态是否在售
 * @property float $saleprice 销售价格
 * @property string $ishot 是否热卖
 * @property int $createtime 创建时间
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shop_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['title','required','message'=>'商品名不能为空'],
            ['description','required','message'=>'商品描述信息不能为空'],
            ['cateid','required','message'=>'分类不能为空'],
            ['cateid','checkCategory'],
            ['price','required','message'=>'商品单价不能为空'],
            [['price','saleprice'],'number','min'=>0.01,'message'=>'价格必须是数字'],
            ['num','integer','min'=>0,'message'=>'库存数量必须是0或正整数'],
            [['issale','ishot','ison','isrecommend','pics'],'safe'],
            ['cover','required','message'=>'封面图不能为空'],
        ];
    }

    /**
     * 新增或者修改商品时,不允许将商品指定到顶级分类下
     */
    public function checkCategory(){
        if(!$this->hasErrors()){
            $product = Category::find()->where('cateid=:id',[':id'=>$this->cateid])->asArray()->one();
            if($product['parentid'] == '0'){
                $this->addError('cateid','商品分类不能为顶级分类');
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'productid' => '商品id',
            'cateid' => '商品分类',
            'title' => '商品名称',
            'description' => '商品描述',
            'num' => '库存数量',
            'price' => '单价',
            'cover' => '封面图',
            'pics' => '缩略图',
            'issale' => '是否促销',
            'saleprice' => '售出价格',
            'ishot' => '是否热卖',
            'ison' => '上/下架',
            'isrecommend' => '是否推荐',
            'createtime' => '创建时间',
        ];
    }

    /**
     * 添加商品信息到数据库
     * @param $post
     * @return bool
     */
    public function add($post){
        if($this->load($post) && $this->save()){
            return true;
        }
        return false;
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($insert){
                $this->createtime = time();
            }
            return true;
        }
        return false;
    }

    /**
     * 获取三条推荐商品信息
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getRecommendProduct(){
        return self::find()->where('isrecommend = "1"')->orderBy('createtime desc')->limit(3)->all();
    }

    /**
     * 获取最新上架的三件商品信息
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getLatestProduct(){
        return self::find()->where('issale= "1" ')->orderBy('createtime desc')->limit(3)->all();
    }
}
