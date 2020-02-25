<!-- ============================================================= HEADER : END ============================================================= -->		<section id="category-grid">
    <div class="container">

        <!-- ========================================= SIDEBAR ========================================= -->
        <div class="col-xs-12 col-sm-3 no-margin sidebar narrow">

            <!-- ========================================= PRODUCT FILTER ========================================= -->
            <div class="widget">
                <h1>商品筛选</h1>
                <div class="body bordered">

                    <div class="category-filter">
                        <h2>品牌</h2>
                        <hr>
                        <ul>
                            <li><input checked="checked" class="le-checkbox" type="checkbox"  /> <label>Samsung</label> <span class="pull-right">(2)</span></li>
                            <li><input  class="le-checkbox" type="checkbox" /> <label>Dell</label> <span class="pull-right">(8)</span></li>
                            <li><input  class="le-checkbox" type="checkbox" /> <label>Toshiba</label> <span class="pull-right">(1)</span></li>
                            <li><input  class="le-checkbox" type="checkbox" /> <label>Apple</label> <span class="pull-right">(5)</span></li>
                        </ul>
                    </div><!-- /.category-filter -->

                    <div class="price-filter">
                        <h2>价格</h2>
                        <hr>
                        <div class="price-range-holder">

                            <input type="text" class="price-slider" value="" >

                            <span class="min-max">
                    Price: ￥89 - ￥2899
                </span>
                            <span class="filter-button">
                    <a href="#">筛选</a>
                </span>
                        </div>
                    </div><!-- /.price-filter -->

                </div><!-- /.body -->
            </div><!-- /.widget -->
            <!-- ========================================= PRODUCT FILTER : END ========================================= -->
            <div class="widget">
                <h1 class="border">特价商品</h1>
                <ul class="product-list">

                </ul>
            </div><!-- /.widget -->
            <!-- ========================================= FEATURED PRODUCTS ========================================= -->
            <div class="widget">
                <h1 class="border">推荐商品</h1>
                <ul class="product-list">

                </ul><!-- /.product-list -->
            </div><!-- /.widget -->
            <!-- ========================================= FEATURED PRODUCTS : END ========================================= -->
        </div>
        <!-- ========================================= SIDEBAR : END ========================================= -->

        <!-- ========================================= CONTENT ========================================= -->

        <div class="col-xs-12 col-sm-9 no-margin wide sidebar">

            <section id="recommended-products" class="carousel-holder hover small">

                <div class="title-nav">
                    <h2 class="inverse">推荐商品</h2>
                    <div class="nav-holder">
                        <a href="#prev" data-target="#owl-recommended-products" class="slider-prev btn-prev fa fa-angle-left"></a>
                        <a href="#next" data-target="#owl-recommended-products" class="slider-next btn-next fa fa-angle-right"></a>
                    </div>
                </div><!-- /.title-nav -->

                <div id="owl-recommended-products" class="owl-carousel product-grid-holder">

                </div><!-- /#recommended-products-carousel .owl-carousel -->
            </section><!-- /.carousel-holder -->
            <section id="gaming">
                <div class="grid-list-products">
                    <h2 class="section-title">所有商品</h2>

                    <div class="control-bar" style="height:60px">

                        <div class="grid-list-buttons">
                            <ul>
                                <li class="grid-list-button-item active"><a data-toggle="tab" href="#grid-view"><i class="fa fa-th-large"></i> 图文</a></li>
                                <li class="grid-list-button-item "><a data-toggle="tab" href="#list-view"><i class="fa fa-th-list"></i> 列表</a></li>
                            </ul>
                        </div>
                    </div><!-- /.control-bar -->

                    <div class="tab-content">
                        <div id="grid-view" class="products-grid fade tab-pane in active">

                            <div class="product-grid-holder">
                                <div class="row no-margin">
                                    <?php foreach($products as $pro): ?>
                                        <div class="col-xs-12 col-sm-4 no-margin product-item-holder hover">
                                            <div class="product-item">
                                                <?php if ($pro['ishot']): ?>
                                                    <div class="ribbon red"><span>HOT</span></div>
                                                <?php endif; ?>
                                                <?php if ($pro['issale']): ?>
                                                    <div class="ribbon green"><span>sale</span></div>
                                                <?php endif; ?>
                                                <?php if ($pro['isrecommend']): ?>
                                                    <div class="ribbon blue"><span>recommond</span></div>
                                                <?php endif; ?>

                                                <div class="image">
                                                    <img alt="" src="<?php echo $pro['cover'] ?>-covermiddle"  />
                                                </div>
                                                <div class="body">
                                                    <?php if($pro['issale']): ?>
                                                        <div class="label-discount green"><?php echo round($pro['saleprice']/$pro['price']*100, 0) ?>% sale</div>
                                                    <?php endif; ?>
                                                    <div class="title">
                                                        <a href="<?php echo yii\helpers\Url::to(['product/detail', 'productid' => $pro['productid']]) ?>"><?php echo $pro['title'] ?></a>
                                                    </div>
                                                </div>
                                                <div class="prices">
                                                    <?php if ($pro['issale']): ?>
                                                        <div class="price-prev">￥<?php echo $pro['price'] ?></div>
                                                        <div class="price-current pull-right">￥<?php echo $pro['saleprice'] ?></div>
                                                    <?php else: ?>
                                                        <div class="price-current pull-right">￥<?php echo $pro['price'] ?></div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="hover-area">
                                                    <div class="add-cart-button">
                                                        <a href="<?php echo yii\helpers\Url::to(['cart/add', 'productid' => $pro['productid']]) ?>" class="le-button">加入购物车</a>
                                                    </div>

                                                </div>
                                            </div><!-- /.product-item -->
                                        </div><!-- /.product-item-holder -->
                                    <?php endforeach; ?>
                                </div><!-- /.row -->
                            </div><!-- /.product-grid-holder -->

                            <div class="pagination-holder">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 text-left">

                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <div class="result-counter">
                                            Showing <span>1-9</span> of <span></span> results
                                        </div>
                                    </div>

                                </div><!-- /.row -->
                            </div><!-- /.pagination-holder -->
                        </div><!-- /.products-grid #grid-view -->

                        <div id="list-view" class="products-grid fade tab-pane ">
                            <div class="products-list">

                            </div><!-- /.products-list -->

                            <div class="pagination-holder">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 text-left">
                                        <ul class="pagination">
                                            <li class="current"><a  href="#">1</a></li>
                                            <li><a href="#">2</a></li>
                                            <li><a href="#">3</a></li>
                                            <li><a href="#">4</a></li>
                                            <li><a href="#">next</a></li>
                                        </ul><!-- /.pagination -->
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="result-counter">
                                            Showing <span>1-9</span> of <span>11</span> results
                                        </div><!-- /.result-counter -->
                                    </div>
                                </div><!-- /.row -->
                            </div><!-- /.pagination-holder -->

                        </div><!-- /.products-grid #list-view -->

                    </div><!-- /.tab-content -->
                </div><!-- /.grid-list-products -->

            </section><!-- /#gaming -->
        </div><!-- /.col -->
        <!-- ========================================= CONTENT : END ========================================= -->
    </div><!-- /.container -->
</section><!-- /#category-grid -->		<!-- ============================================================= FOOTER ============================================================= -->
