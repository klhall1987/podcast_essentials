<?php

/*
Plugin Name: Podcast Essentials
Description: A call to action widget for your WordPress site.
Version: 0.2
Author: Kenny Hall
Author URI: http://hardlycausal.net
Text Domain: podcast-essentials
*/

final class Podcast_Essentials
{
    public static $instance;

    /**
     * @var string
     */
    public static $url = '';

    /**
     * @var string
     */
    public static $dir = '';

    /**
     *
     * @var array
     */
    public $admin = array();

    /**
     * Used to register our WordPress CPT.
     * @var array
     */
    public $menu = array();

    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new Podcast_Essentials();
        }

        self::$dir = plugin_dir_path( __FILE__ );
        
        self::$url = plugin_dir_url( __FILE__ );

        if( ! defined( 'PE_PLUGIN_URL' ) ){
            define( 'PE_PLUGIN_URL', self::$url );
        }

        /*
        * Register our autoloader
        */
        spl_autoload_register( array( self::$instance, 'autoloader' ) );

        self::$instance->menu[ 'submenu' ] = new PE_Admin_Menus_Submenu();

        self::$instance->widget[] = new PE_Admin_Widget();

        register_activation_hook( __FILE__, array( self::$instance, 'activation' ) );

        return static::$instance;
    }

    protected function __construct()
    {
    }

    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     *
     * @return void
     */
    private function __clone()
    {
    }

    public function autoloader( $class_name )
    {
        if( class_exists( $class_name ) ) return;

        /* Podcast Essentials Prefix */
        if (false !== strpos($class_name, 'PE_')) {
            $class_name = str_replace('PE_', '', $class_name);
            $classes_dir = realpath(plugin_dir_path(__FILE__)) . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR;
            $class_file = str_replace('_', DIRECTORY_SEPARATOR, $class_name) . '.php';
            if (file_exists($classes_dir . $class_file)) {
                require_once $classes_dir . $class_file;
            }
        }
    }

    public function load_templates( $template )
    {
        $classes_dir = realpath(plugin_dir_path(__FILE__)) . DIRECTORY_SEPARATOR . 'includes/Templates' . DIRECTORY_SEPARATOR;
        $template_name = $template . '.html.php';
        if ( file_exists($classes_dir . $template_name ) ) {
            require_once $classes_dir . $template_name;
        }
    }
}

function Podcast_Essentials()
{
    return Podcast_Essentials::getInstance();
}

Podcast_Essentials();