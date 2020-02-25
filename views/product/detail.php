<?php
use yii\bootstrap\ActiveForm;
?>
<!-- ============================================================= HEADER : END ============================================================= -->		<div id="single-product">
    <div class="container">

        <div class="no-margin col-xs-12 col-sm-6 col-md-5 gallery-holder">
            <div class="product-item-holder size-big single-product-gallery small-gallery">

                <div id="owl-single-product">
                    <div class="single-product-gallery-item" id="slide1">
                        <a data-rel="prettyphoto" href="">
                            <img class="img-responsive" alt="" src="<?php echo $product['cover'].'-coverbig'; ?>"  />
                        </a>
                    </div><!-- /.single-product-gallery-item -->

                </div><!-- /.single-product-slider -->


                <div class="single-product-gallery-thumbs gallery-thumbs">

                    <div id="owl-single-product-thumbnails">
                        <?php
                            foreach((array)json_decode($product['pics'],true) as $v){
                                echo "<img src='".$v."' alt=''>";
                            }
                        ?>
                    </div><!-- /#owl-single-product-thumbnails -->

                    <div class="nav-holder left hidden-xs">
                        <a class="prev-btn slider-prev" data-target="#owl-single-product-thumbnails" href="#prev"></a>
                    </div><!-- /.nav-holder -->

                    <div class="nav-holder right hidden-xs">
                        <a class="next-btn slider-next" data-target="#owl-single-product-thumbnails" href="#next"></a>
                    </div><!-- /.nav-holder -->

                </div><!-- /.gallery-thumbs -->

            </div><!-- /.single-product-gallery -->
        </div><!-- /.gallery-holder -->
        <div class="no-margin col-xs-12 col-sm-7 body-holder">
            <div class="body">
                <!--<div class="star-holder inline"><div class="star" data-score="4"></div></div>-->
                <div style="margin-top:30px"></div>
                <div class="title"><a href="#"></a></div>
                <div class="availability" style="font-size:15px;margin:0;line-height:30px"><label>库存:</label><span class="available"> <?php echo $product['num']; ?> </span></div>
                <!--<div class="excerpt">
        <p></p>
        </div>-->

                <div class="prices">
                    <?php echo $product['price']; ?>
                </div>

                <div class="qnt-holder">
                    <?php $form = ActiveForm::begin([
                        'action' => yii\helpers\Url::to(['cart/add']),
                    ]) ?>
                    <div class="le-quantity">
                        <a class="minus" href="#reduce"></a>
                        <input name="productnum" readonly="readonly" type="text" value="1" />
                        <a class="plus" href="#add"></a>
                    </div>
                    <input type="hidden" name="price" value="">
                    <input type="hidden" name="productid" value="">
                    <input type='submit' id="addto-cart" class="le-button huge" value="加入购物车">
                    <?php ActiveForm::end(); ?>
                </div><!-- /.qnt-holder -->
            </div><!-- /.body -->

        </div><!-- /.body-holder -->
    </div><!-- /.container -->
</div><!-- /.single-product -->

<!-- ========================================= SINGLE PRODUCT TAB ========================================= -->
<section id="single-product-tab">
    <div class="container">
        <div class="tab-holder">

            <ul class="nav nav-tabs simple" >
                <li class="active"><a href="#description" data-toggle="tab">商品详情</a></li>
            </ul><!-- /.nav-tabs -->

            <div class="tab-content">
                <div class="tab-pane active" id="description">
                    <p><?php echo $product['description']; ?></p>
                </div><!-- /.tab-pane #description -->

            </div><!-- /.tab-content -->

        </div><!-- /.tab-holder -->
    </div><!-- /.container -->
</section><!-- /#single-product-tab -->
<!-- ========================================= SINGLE PRODUCT TAB : END ========================================= -->
<!-- ========================================= RECENTLY VIEWED ========================================= -->
<section id="recently-reviewd" class="wow fadeInUp">
    <div class="container">
        <div class="carousel-holder hover">

            <div class="title-nav">
                <h2 class="h1">所有商品</h2>
                <div class="nav-holder">
                    <a href="#prev" data-target="#owl-recently-viewed" class="slider-prev btn-prev fa fa-angle-left"></a>
                    <a href="#next" data-target="#owl-recently-viewed" class="slider-next btn-next fa fa-angle-right"></a>
                </div>
            </div><!-- /.title-nav -->

            <div id="owl-recently-viewed" class="owl-carousel product-grid-holder">

            </div><!-- /#recently-carousel -->

        </div><!-- /.carousel-holder -->
    </div><!-- /.container -->
</section><!-- /#recently-reviewd -->
<!-- ========================================= RECENTLY VIEWED : END ========================================= -->		<!-- ============================================================= FOOTER ============================================================= -->

