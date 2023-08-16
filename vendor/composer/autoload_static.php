<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit35a9fb465f8dc19da6761d59d870c617
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit35a9fb465f8dc19da6761d59d870c617::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit35a9fb465f8dc19da6761d59d870c617::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit35a9fb465f8dc19da6761d59d870c617::$classMap;

        }, null, ClassLoader::class);
    }
}