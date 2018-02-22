<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{$TITLE_SITE_PAGE}</title>
{if isset($CSSS)}
    {foreach $CSSS as $css }
     <link href="{$css}" rel="stylesheet">
    {/foreach}
{/if}
    <link href="www/include/css/bootstrap.min.css" rel="stylesheet">
    <link href="www/include/css/font-awesome.min.css" rel="stylesheet">
    <link href="www/include/css/pe-icons.css" rel="stylesheet">
    <link href="www/include/css/prettyPhoto.css" rel="stylesheet">
    <link href="www/include/css/animate.css" rel="stylesheet">
    <link href="www/include/css/style.css" rel="stylesheet">
{if issset($SCRIPTS)}    
    {foreach $SCRIPTS as $script}
        <script src="{$script}"></script>
    {/foreach}
{/if}
    <script src="www/include/js/jquery.js"></script>
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->  
{if isset($ICONS)}
    {foreach $ICONS as $icon}
        {if isset($icon.sizes)}
        <link rel="{$icon.rel}" sizes="{$icon.size}" href="{$icon.href}">
        {else}
        <link rel="{$icon.rel}" href="{$icon.href}">
        {/if}
    {/foreach}
{/if}

if isset($)
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon" sizes="144x144" href="images/ico/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/ico/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/ico/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" href="images/ico/apple-touch-icon-57x57.png">
