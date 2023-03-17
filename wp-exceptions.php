<?php

/**
 * Plugin Name: Exceptions made simple
 * Plugin URI:  https://github.com/matapatos/wp-exceptions
 * Description: Don't feel sorry to interrupt. Exceptions made simple.
 * Version:     1.0.0
 * Author:      André Gil
 * Author URI:  https://github.com/matapatos
 *
 * @package wp-exceptions
 * @version 1.0.0
 */

declare(strict_types=1);

// Abort if this file is called directly.
if (!defined('WPINC')) {
    die;
}

$composer = __DIR__ . '/vendor/autoload.php';
if (!file_exists($composer)) {
    wp_die(
        esc_html__('Error locating autoloader in (mu-)plugins/wp-exceptions. Please run <code>composer install</code>.')
    );
}

require_once $composer;
