<?php
define( 'WP_CACHE', true );

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u281037707_vho1g' );

/** Database username */
define( 'DB_USER', 'u281037707_1RZ1Y' );

/** Database password */
define( 'DB_PASSWORD', 'oPdFX7pOQp' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          '!1KChM4R:Vv!dRI -6>t6A36}]MFB,%F+o`>J{)&Jgg*K-u p*a.-T9N>POM?v(2' );
define( 'SECURE_AUTH_KEY',   'i,hA([SMqeXx/eDpeYce%AJOQ9;!ha-z_Yw!3.F!Tg]TAO^6+0HzA._/wyK0Y!ud' );
define( 'LOGGED_IN_KEY',     '&9FaMn$Q@@Y_{&S5 _Tbbc` M}t2tY5<^g:!ZcN46b_C`17PaKs|dS_<z`R+eOMv' );
define( 'NONCE_KEY',         'O3[06SZ0t>2!y%AT9OKM^z]^CkCp3!J-exA{VxBr7KIRP<GucA<sST0vkS>S3c @' );
define( 'AUTH_SALT',         '~,?aqle/C{eXk_m4^xm5FR/S`K<,tNp)nYA~OY>v6]z<}l,^r |R]t]`b$gvZwAl' );
define( 'SECURE_AUTH_SALT',  ';4@!V=q+a^kRm/M64?u~09gUa].aYL`>/qC%[e%5~_HB+1fi ,?U_%ffXv87j/S$' );
define( 'LOGGED_IN_SALT',    '/Dis+kqfh`W,0muP]f090{J>{$zgGqq;ZqzSU6  .7|V1K/Kf8I2L+a9q:j.u>Da' );
define( 'NONCE_SALT',        'Mj$%9NRgR]5=SrQyu<T #[-+ZrOo~GjuC711F-2^s0.zX1Yj/q m_6 K/XhR(I|U' );
define( 'WP_CACHE_KEY_SALT', 'L9u}9O~ {*-+.*ABN)`|7#9]bE/vAd9Z,cHYL]aH,zJ2QXk<@,<5,<%Fa4Q6[%MZ' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'FS_METHOD', 'direct' );
define( 'COOKIEHASH', 'e21f0da5a577ef1776a87740bae8174c' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
