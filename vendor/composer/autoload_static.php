<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9751d00bb278730d1a62eaa71c413d0c
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PublicVar\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PublicVar\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9751d00bb278730d1a62eaa71c413d0c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9751d00bb278730d1a62eaa71c413d0c::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
