<?php
require 'vendor/autoload.php';

$f3 = \Base::instance();

$f3->config('conf/index.ini');

$f3->run();
