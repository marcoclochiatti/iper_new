<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    {$TITLE_SITE_PAGE|@print_r}
    <title>{$TITLE_SITE_PAGE}</title>
{if isset($rel_header)}
    {foreach $rel_header as $ref }
        {$ref}
{*        {if isset($ref.params)}}
    <link rel="apple-touch-icon" {$ref.params,.name}="{$ref.params.value}" href="images/ico/apple-touch-icon-144x144.png">
        {else}    
    <link href="{$ref.url}" rel="{$ref.rel}">
        {/if}   *}
    {/foreach}
{/if}
{*    <link href="www/include/css/bootstrap.min.css" rel="stylesheet">
    <link href="www/include/css/font-awesome.min.css" rel="stylesheet">
    <link href="www/include/css/pe-icons.css" rel="stylesheet">
    <link href="www/include/css/prettyPhoto.css" rel="stylesheet">
    <link href="www/include/css/animate.css" rel="stylesheet">
    <link href="www/include/css/style.css" rel="stylesheet">  *}
{if isset($script_header)}        
    {foreach $script_header as $script}
        {$script}
{*        <script src="{$script}"></script> *}
    {/foreach}
{/if}
{*
    <script src="www/include/js/jquery.js"></script>
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->  
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon" sizes="144x144" href="images/ico/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/ico/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/ico/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" href="images/ico/apple-touch-icon-57x57.png">
*}