<?php

/**
 * An autoloader for Exads\Foo classes. This should be require()d by
 * the user before attempting to instantiate any of the Exads
 * classes.
 */
spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    $path = dirname(__FILE__).'/'.$class.'.php';
    if (file_exists($path)) {
        require_once $path;
    }
    $path = dirname(__FILE__).'/../test/'.$class.'.php';
    if (file_exists($path)) {
        require_once $path;
    }
});
