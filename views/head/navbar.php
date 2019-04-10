
<body class="font-class">
    <nav class="navbar navbar-default navbar-fixed-top top-nav" style="padding:3px;background: #FFF; box-shadow: 0px 3px 3px #bbb;border:none;border-radius:0" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header" style="width:100%">
                <a style="color:#000" class="navbar-brand" href=""><?php echo $page_name; ?></a>


                <?php
                    if(isset($_SESSION['DIGITRON_2017']) && !isset($hide_more)){
                        echo '
                            <div style="" class="pull-right dropdown">
                                <i style="font-size:18px;line-height:2.5;font-weight:200;cursor:pointer;color:#000" class="pe-7s-more text-right dropdown-toggle" data-toggle="dropdown"></i>
                                <ul class="dropdown-menu">
                                    <li><a href="logout"> Logout</a></li>
                                </ul>
                            </div>
                        ';
                    }
                ?>
                
            </div>
            
        </div>
    </nav>