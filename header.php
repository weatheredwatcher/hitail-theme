<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <link rel="icon"
          type="image/png"
          href="/wp-content/themes/hitail-theme/hightail-app-icon-light-FINAL.jpg">
    <?php wp_head(); ?>
</head>

  <body>
   <?php include 'header-nav.php'; ?>
<main role="main">

  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron">
<div class=overlay>
    <div class="container jb-text">
	          <h1 class="display-3">Create better</h1>
      <p>Articles to inspire you to work better, together.</p>
    </div>
</div>
</div>
  </div>



<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
