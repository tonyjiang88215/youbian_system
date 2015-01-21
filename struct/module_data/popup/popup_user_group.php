<?php
$Views = array();

$treeHTMLModule = new lib_module('module/source/tree_html.module.php');
$treeHTMLModule->setView(array('type'=>'js' , 'treeClass'=>'treeClass'));

$Views['treeHTML'] = $treeHTMLModule->render();

