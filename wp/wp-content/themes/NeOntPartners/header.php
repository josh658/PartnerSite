<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php the_title(); ?></title>
    <?php wp_head(); ?>
</head>
<body>
    <header id="sticky" class="sticky-header">
        <div class="header-item-centering">    
            <a class=" comp-name" href="<?php echo site_url('');?>"><h3>Northeastern Ontario Tourism <span>Partners</span></h3></a>
            <nav class="header-nav">
                <ul>
                    <a class="list-item" href="<?php echo site_url('/news-letter');?>">
                        <li>News Letter</li>
                    </a>
                    <a class="list-item" href="<?php echo site_url('/board-minutes');?>">
                        <li>Board Minutes</li>
                    </a>
                    <div class="list-item">                        
                        <li class="dropdown">Organizations
                            <ul class="dropdown-list">
                                <li><a href="<?php echo site_url('/neont');?>">NeOnt</a></li>
                                <li><a href="<?php echo site_url('/do');?>">DO</a></li>
                                <li><a href="<?php echo site_url('/dno');?>">DNO</a></li>
                            </ul>
                        </li>
                    </div>
                </ul>
            </nav>
        </div>
    </header>