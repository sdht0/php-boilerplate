<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo isset($pagetitle) ? $pagetitle : "PHPBoilerplate" ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Place favicon.ico and apple-touch-icon(s) in the root directory -->

        <link rel="stylesheet" href="<?php echo CSS_URL; ?>normalize.css">
        <link rel="stylesheet" href="<?php echo CSS_URL; ?>main.css">
        <script src="<?php echo JS_URL; ?>vendor/modernizr-2.7.1.min.js"></script>
    </head>
    <body> 
        <!--[if lt IE 8]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->