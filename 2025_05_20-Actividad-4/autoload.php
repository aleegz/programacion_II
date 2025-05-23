<?php
spl_autoload_register(function ($class) {
    $base_dir = __DIR__ . '/';
    $class_path = str_replace('\\', '/', $class) . '.php';
    $file = $base_dir . $class_path;

    if (file_exists($file)) {
        require $file;
    }
});
