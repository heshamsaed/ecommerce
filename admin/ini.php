<?php

    $dbn= include 'connect.php';

    //routes

    $tbl = 'includes/templates/';
    $lang='includes/languages/';
    $fun ='includes/functions/';
    $css = 'layout/css/';
    $js = 'layout/js/';

    //include the important filesize
    include $fun.'functions.php';
    include $lang.'english.php';
    include $tbl.'header.php';

    if(!isset($nonavbar)){include $tbl. 'navbar.php';}
