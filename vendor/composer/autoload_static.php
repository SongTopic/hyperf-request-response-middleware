<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb308e441afc89212501a12ecda021f3b
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'Wufly\\Log\\' => 10,
            'Wufly\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Wufly\\Log\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Wufly\\' => 
        array (
            0 => __DIR__ . '/..' . '/wufly/logstash/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb308e441afc89212501a12ecda021f3b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb308e441afc89212501a12ecda021f3b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb308e441afc89212501a12ecda021f3b::$classMap;

        }, null, ClassLoader::class);
    }
}
