<?php

spl_autoload_register(function ($class_name) {
    include(ROOT . $class_name . '.php');
});