<?php

namespace app\models;

use Yii;

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
            [['cateid', 'num', 'createtime'], 'integer'],
            [['cateid','title','price','description','num'],'required'],
            [['description', 'pics', 'issale', 'ishot'], 'string'],
            [['price', 'saleprice'], 'number'],
            [['title', 'cover'], 'string', 'max' => 200],
        ];
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
            'issale' => '是否在售',
            'saleprice' => '售出价格',
            'ishot' => '是否热卖',
            'ison' => '上/下架',
            'isrecommend' => '是否推荐',
            'createtime' => '创建时间',
        ];
    }
}
