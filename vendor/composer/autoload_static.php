<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1ab08b29a3315193994b70e99057d81e
{
    public static $prefixLengthsPsr4 = array (
        'E' => 
        array (
            'ECF\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ECF\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1ab08b29a3315193994b70e99057d81e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1ab08b29a3315193994b70e99057d81e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit1ab08b29a3315193994b70e99057d81e::$classMap;

        }, null, ClassLoader::class);
    }
}
