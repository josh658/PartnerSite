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
            <h3>Northeastern Ontario Tourism <span>Partners</span></h3>
            <nav class="header-nav">
                <ul>
                    <a href="<?php get_page_uri( "News Letter" )?>">
                        <li>News Letter</li>
                    </a>
                    <a href="#">
                        <li>Board Minutes</li>
                    </a>
                    <a href="#">
                        <li class="dropdown">Organizations
                            <ul class="dropdown-list">
                                <li>Neont</li>
                                <li>DO</li>
                                <li>DNO</li>
                            </ul>
                        </li>
                    </a>
                </ul>
            </nav>
        </div>
    </header>