<?php

/**
 * @author Marcio Figueredo
 * @copyright Copyright (c) 2026
 */
function autoLoader($className) {

    $directories = array(
        $_SERVER['DOCUMENT_ROOT'] . '/app/',
        $_SERVER['DOCUMENT_ROOT'] . '/app/BD/',
        $_SERVER['DOCUMENT_ROOT'] . '/app/Control/',
        $_SERVER['DOCUMENT_ROOT'] . '/app/Core/',
        $_SERVER['DOCUMENT_ROOT'] . '/app/DAO/',
        $_SERVER['DOCUMENT_ROOT'] . '/app/Libs/',
        $_SERVER['DOCUMENT_ROOT'] . '/app/Model/',
        $_SERVER['DOCUMENT_ROOT'] . '/'
    );

    $fileNameFormats = array('%s.php', '%s.class.php', '%s.class.inc');

    // this is to take care of the PEAR style of naming classes
    $path = str_ireplace('_', '/', $className);
    if (@include_once $path . '.php') {
        return;
    }

    foreach ($directories as $directory) {
        foreach ($fileNameFormats as $fileNameFormat) {
            $path = $directory . sprintf($fileNameFormat, $className);
            if (file_exists($path)) {
                include_once $path;
                return;
            }
        }
    }
}

spl_autoload_register('autoLoader');
?>