<?php
session_start();

require 'config.php';
require 'vendor/autoload.php';
require_once('vendor/autoload.php');
$core = new Core\Core();
$core->run();