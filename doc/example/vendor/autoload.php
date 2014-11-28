<?php

function my_classmap() {
    include dirname(__FILE__) . '/composer/autoload_classmap.php';
    return $classmap;
}

$map = my_classmap();

foreach ($map as $class => $path) {
    if (class_exists($class)) {
        continue;
    }
    require_once $path;
}

