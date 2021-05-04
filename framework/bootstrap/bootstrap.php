<?php

require_once '../core/ClassLoader.php';

$loader = new ClassLoader();
$loader->registerDirectory("../models");
$loader->register();