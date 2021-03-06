<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdf9169908944cba9c79605f3ebd0e641
{
    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'BeNouze\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'BeNouze\\' => 
        array (
            0 => __DIR__ . '/../..' . '/class',
        ),
    );

    public static $classMap = array (
        'AltoRouter' => __DIR__ . '/..' . '/altorouter/altorouter/AltoRouter.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitdf9169908944cba9c79605f3ebd0e641::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitdf9169908944cba9c79605f3ebd0e641::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitdf9169908944cba9c79605f3ebd0e641::$classMap;

        }, null, ClassLoader::class);
    }
}
