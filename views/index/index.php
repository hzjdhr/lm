<?php include('header.php') ?>

    <div class="w_container">
        <div class="container">
            <div class="row w_main_row">
                <div class="col-lg-9 col-md-9 w_main_left">
                    <!--滚动图开始-->
                    <div class="panel panel-default">

                        <div id="w_carousel" class="carousel slide w_carousel" data-ride="carousel">
                            <!-- Indicators -->
                            <ol class="carousel-indicators">
                                <li data-target="#w_carousel" data-slide-to="0" class="active"></li>
                                <li data-target="#w_carousel" data-slide-to="1"></li>
                                <li data-target="#w_carousel" data-slide-to="2"></li>
                            </ol>

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" role="listbox">
                                <div class="item active">
                                    <img src="/statics/index/img/lun1.jpg" alt="...">
                                    <div class="carousel-caption">
                                        <h3>“绝杀”中国AI，美国会打英伟达这张牌吗？</h3>

                                    </div>
                                </div>
                                <div class="item">
                                    <img src="/statics/index/img/lun2.jpg" alt="...">
                                    <div class="carousel-caption"><h3>@程序员，与JavaScript 疲劳症SayBye！</h3></div>
                                </div>
                                <div class="item">
                                    <img src="/statics/index/img/lun3.jpg" alt="...">
                                    <div class="carousel-caption"><h3>Python爬虫爬取智联招聘（进阶版）</h3></div>
                                </div>

                            </div>

                            <!-- Controls -->
                            <a class="left carousel-control" href="#w_carousel" role="button" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#w_carousel" role="button" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>

                    </div>


                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">最新发布</h3>
                        </div>

                        <div class="panel-body">

                            <!--文章列表开始-->
                            <div class="contentList">


                                <?php foreach ($arrs as $key => $arr) { ?>
                                    <div class="panel panel-default">
                                        <div class="panel-body">

                                            <h4><a class="title" href="?m=view&f=detail&article_id=<?= ($arr['id']) ?>"><?= $arr['name'] ?></a>
                                            </h4>
                                            <p>
                                                <a class="label label-default"><?= $arr['cate_name'] ?></a>

                                            </p>
                                            <p><span class="count"> <img src="/statics/index/img/star-off.png">
                                                <a href="#"><?= $arr['username'] ?></a></span>
                                                <span class="count"> <img src="/statics/index/img/star-off.png"></i>阅读:<?= $arr['hits'] ?></span><span
                                                        class="count">
                                                <span class="count"> <img src="/statics/index/img/star-off.png"><?= $arr['created_at'] ?></span>
                                            </p>


                                        </div>
                                    </div>
                                <?php } ?>


                            </div>
                            <!--文章列表结束-->

                        </div>
                    </div>
                </div>

                <!--左侧开始-->
                <div class="col-lg-3 col-md-3 w_main_right">

                    <div class="panel panel-default sitetip">
                        <a href="">
                            <strong>站点公告</strong>
                            <h3 class="title">程序员</h3>
                            <p class="overView">
                                我是一个程序员啦啦啦啦啦，我是一个程序员啦啦啦啦啦啦,我是一个程序员啦啦啦啦啦，我是一个程序员啦啦啦啦啦啦,我是一个程序员啦啦啦啦啦，我是一个程序员啦啦啦啦啦啦,我是一个程序员啦啦啦啦啦，我是一个程序员啦啦啦啦啦啦</p>
                        </a>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">热门标签</h3>
                        </div>
                        <div class="panel-body">
                            <div class="labelList">
                                <a class="label label-default">java</a>
                                <a class="label label-default">tomcat负载均衡</a>
                                <a class="label label-default">panel</a>
                                <a class="label label-default">jQuery</a>
                                <a class="label label-default">jQuery选择器</a>
                                <a class="label label-default" >linux</a>
                                <a class="label label-default" >Nginx</a>
                                <a class="label label-default">linux文件类型</a>
                                <a class="label label-default">chrome</a>
                                <a class="label label-default" >Redis</a>
                                <a class="label label-default" >spring</a>
                                <a class="label label-default" >tomcat</a>
                                <a class="label label-default">SyntaxHighlighter</a>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">最新发布</h3>
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled sidebar">
                                <?php foreach ($arrs as $arr) { ?>
                                <li>
                                    <a href="?m=view&f=detail&article_id=<?= ($arr['id']) ?>"><?= $arr['name'] ?></a>
                                </li>
    <?php } ?>


                            </ul>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">友情链接</h3>
                        </div>
                        <div class="panel-body">
                            <div class="newContent">
                                <ul class="list-unstyled sidebar shiplink">
                                    <li>
                                        <a href="https://www.baidu.com/" target="_blank">百度</a>
                                    </li>
                                    <li>
                                        <a href="https://www.oschina.net/" target="_blank">开源中国</a>
                                    </li>
                                    <li>
                                        <a href="http://www.ulewo.com/" target="_blank">有乐网</a>
                                    </li>
                                    <li>
                                        <a href="http://www.sina.com.cn/" target="_blank">新浪网</a>
                                    </li>
                                    <li>
                                        <a href="http://www.qq.com/" target="_blank">腾讯网</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
<?php include('footer.php') ?>