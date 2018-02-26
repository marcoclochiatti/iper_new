<?php
/* Smarty version 3.1.30, created on 2018-02-26 15:00:30
  from "C:\xampp\htdocs\iper\www\smarty\templates\header.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a9412fe358fd2_01143084',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'aba1d4a90be97ba6bd23ad400cb30375c6b3e4d8' => 
    array (
      0 => 'C:\\xampp\\htdocs\\iper\\www\\smarty\\templates\\header.tpl',
      1 => 1519404738,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a9412fe358fd2_01143084 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php echo print_r($_smarty_tpl->tpl_vars['TITLE_SITE_PAGE']->value);?>

    <title><?php echo $_smarty_tpl->tpl_vars['TITLE_SITE_PAGE']->value;?>
</title>
<?php if (isset($_smarty_tpl->tpl_vars['rel_header']->value)) {?>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rel_header']->value, 'ref');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['ref']->value) {
?>
        <?php echo $_smarty_tpl->tpl_vars['ref']->value;?>


    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['script_header']->value)) {?>        
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['script_header']->value, 'script');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['script']->value) {
?>
        <?php echo $_smarty_tpl->tpl_vars['script']->value;?>


    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

<?php }
}
}
