    <link rel="stylesheet" href="assets/admin/css/compiled/user-list.css" type="text/css" media="screen" />
    <!-- main container -->
    <?php use yii\helpers\Url; ?>

        
    <div class="content">
            <div id="pad-wrapper" class="users-list">
                <div class="row-fluid header">
                    <h3>商品列表</h3>
                    <div class="span10 pull-right">
                        <a href="<?php echo yii\helpers\Url::to(['product/add']) ?>" class="btn-flat success pull-right">
                            <span>&#43;</span>
                            添加新商品
                        </a>
                    </div>
                </div>
                <?php
                    if(Yii::$app->session->hasFlash('info')){
                        echo Yii::$app->session->getFlash('info');
                    }
                ?>
                <!-- Users table -->
                <div class="row-fluid table">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="span6 sortable">
                                    <span class="line"></span>商品名称
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>商品库存
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>商品单价
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>是否热卖
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>是否促销
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>促销价
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>是否上架
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>是否推荐
                                </th>

                                <th class="span3 sortable align-right">
                                    <span class="line"></span>操作
                                </th>
                            </tr>

                        </thead>
                        <tbody>
                        <!-- row -->
                        <?php foreach($model as $product): ?>
                            <tr class="first">
                                <td>
                                    <img src="<?php echo $product->cover; ?>-coversmall" class="img-circle avatar hidden-phone" />
                                    <a href="#" class="name"><?php echo $product->title; ?></a>
                                </td>
                                <td><?php echo $product->num;?></td>
                                <td><?php echo $product->price;?></td>
                                <td><a href="<?= Url::to(['product/edit','productid'=>$product->productid,'type'=>'ishot','currentStatus'=>$product->ishot]); ?>"><?php $hot = ['否','是']; echo $hot[$product->ishot];?> </a></td>
                                <td><a href="<?= Url::to(['product/edit','productid'=>$product->productid,'type'=>'issale','currentStatus'=>$product->issale]); ?>"><?php $sale = ['否','是']; echo $sale[$product->issale]?></a></td>
                                <td><?php echo $product->saleprice; ?></td>
                                <td><a href="<?= Url::to(['product/edit','productid'=>$product->productid,'type'=>'ison','currentStatus'=>$product->ison]); ?>"><?php $on = ['否','是']; echo $on[$product->ison]?></a></td>
                                <td><a href="<?= Url::to(['product/edit','productid'=>$product->productid,'type'=>'isrecommend','currentStatus'=>$product->isrecommend]); ?>"><?php $re = ['否','是']; echo $re[$product->isrecommend]?></a></td>
                                <td  class="span3 sortable align-right">
                                    <a href="<?= Url::to(['product/modify','productid'=>$product->productid]); ?>">编辑</a>
                                    <a href="<?= Url::to(['product/delete','productid'=>$product->productid]); ?>">删除</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="pagination pull-right">
                    <?= yii\widgets\LinkPager::widget([
                            'pagination' => $pages
                    ])?>
                </div>
                <!-- end users table -->
            </div>
        </div>

    <!-- end main container -->
