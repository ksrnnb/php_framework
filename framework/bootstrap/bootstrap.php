<?php

require_once '../core/ClassLoader.php';

$loader = new ClassLoader();
$loader->registerDirectory("../core");
$loader->registerDirectory("../controllers");
$loader->registerDirectory("../models");
$loader->registerDirectory("../helpers");
$loader->registerDirectory("../db");
$loader->registerDirectory("../models/models");
$loader->register();