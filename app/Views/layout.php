<?php
require_once('Header.php');
$this->renderSection('css');
require_once('Menu.php');
$this->renderSection('main');
$this->renderSection('javascript');
require_once('Footer.php');

?>