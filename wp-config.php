<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordtest' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'MariaDB-10.3' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'D|#45?.fW/UnXKQWgi+pWp*,68(6YCD8$V<>i`z@pmA~d<w~l}NjzY=JD~R!ei54' );
define( 'SECURE_AUTH_KEY',  '._jo&<YTaU+nIUN;R6xx@$Sn~KfjuT(T+/v).Rq8^MQPjHKeaWxo`Wts7:F((4&r' );
define( 'LOGGED_IN_KEY',    'JBY]4]P![|8rTeu,( JPepe[0,&ydF ,/f4clAxp{l}92!!-7z;mGh2M|=OYwSlZ' );
define( 'NONCE_KEY',        'QvBx NWoaeHajGq`hn]O(7^~P0.#!GtZ|Yk=ZCd%i/[~/bb2ZW~O5c%2dW$?sh`i' );
define( 'AUTH_SALT',        'm`z#Ub}A/EFe&@7l}]f*_f_`Cu~ utV%O+od8b0RM<n;_i.<~S+nXE5,*JlhkCVl' );
define( 'SECURE_AUTH_SALT', '[b%?>cp<dX8nDh?#wcR$LFi!&ssq}#v_I{bZcm;*cLSFwj~<v{D6a,!`n%.[vo>O' );
define( 'LOGGED_IN_SALT',   '|z79-eww1$%BjdUAw}fWJgOA%.gyU_</^ty[GxLm6Gz,*;qtkXK3d#hZ`[{FnXI0' );
define( 'NONCE_SALT',       'TN$4NEu;oBf=-+6wm[?<ff#tl_mHW>jB=pJY@Q(EK:JTqJUB/o~LYz<1|;[r~8O>' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
