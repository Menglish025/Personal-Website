<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdd5dbbf9de82a63d1c80d0ffa28a72a3
{
    public static $prefixLengthsPsr4 = array (
        'a' => 
        array (
            'apimatic\\jsonmapper\\' => 20,
        ),
        'U' => 
        array (
            'Unirest\\' => 8,
        ),
        'S' => 
        array (
            'Stripe\\' => 7,
            'Square\\' => 7,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
        'C' => 
        array (
            'Core\\' => 5,
            'CoreInterfaces\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'apimatic\\jsonmapper\\' => 
        array (
            0 => __DIR__ . '/..' . '/apimatic/jsonmapper/src',
        ),
        'Unirest\\' => 
        array (
            0 => __DIR__ . '/..' . '/apimatic/unirest-php/src',
        ),
        'Stripe\\' => 
        array (
            0 => __DIR__ . '/..' . '/stripe/stripe-php/lib',
        ),
        'Square\\' => 
        array (
            0 => __DIR__ . '/..' . '/square/square/src',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/src',
        ),
        'Core\\' => 
        array (
            0 => __DIR__ . '/..' . '/apimatic/core/src',
        ),
        'CoreInterfaces\\' => 
        array (
            0 => __DIR__ . '/..' . '/apimatic/core-interfaces/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'R' => 
        array (
            'Rs\\Json' => 
            array (
                0 => __DIR__ . '/..' . '/php-jsonpointer/php-jsonpointer/src',
            ),
        ),
        'P' => 
        array (
            'PayPal' => 
            array (
                0 => __DIR__ . '/..' . '/paypal/rest-api-sdk-php/lib',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitdd5dbbf9de82a63d1c80d0ffa28a72a3::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitdd5dbbf9de82a63d1c80d0ffa28a72a3::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitdd5dbbf9de82a63d1c80d0ffa28a72a3::$prefixesPsr0;
            $loader->classMap = ComposerStaticInitdd5dbbf9de82a63d1c80d0ffa28a72a3::$classMap;

        }, null, ClassLoader::class);
    }
}