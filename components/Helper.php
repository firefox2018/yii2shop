<?php
/**
 * Created by PhpStorm.
 * User: flyingfox
 * Date: 2020/1/16
 * Time: 22:34
 */

namespace app\components;
use app\models\Category;

class Helper
{
    public static function topCate(){
        return Category::find()->where('parentid=:id',[':id'=>0])->select('title')->indexBy('cateid')->column();
    }
}