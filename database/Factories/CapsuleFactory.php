<?php
namespace eDreams\Database\Factories;

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Class CapsuleFactory.
 *
 * This class is responsible for creating a singleton
 * database manager instance with the database configurations.
 */
class CapsuleFactory
{
    /**
     * @var Capsule $instance - Singleton Capsule instance.
     */
    private static $instance = null;

    /**
     * Creates a new Capsule instance.
     *
     * @return Capsule
     */
    private static function create(): Capsule
    {
        // Starts Capsule instance.
        $capsule = new Capsule();

        // Get the configurations from the database.
        $config = include(BASE_ROOT . '/config/database.php');

        // Add the configurations in the config file.
        $capsule->addConnection([
            'driver'    => $config['driver'],
            'host'      => $config['host'],
            'database'  => $config['name'],
            'username'  => $config['user'],
            'password'  => $config['pass'],
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ]);

        // Set the capsule as global.
        $capsule->setAsGlobal();

        return $capsule;
    }

    /**
     * Get a singleton Capsule instance.
     *
     * @return Capsule
     */
    public static function get(): Capsule
    {
        if (self::$instance === null) {
            self::$instance = self::create();
        }

        return self::$instance;
    }
}