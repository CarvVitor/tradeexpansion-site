<?php
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
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',          'r$$1bfAFMw *x9yot&J;mDj2d[0f -BoF|>4/mCb:CyDj={y}l3E7nGbN>UlEB%3' );
define( 'SECURE_AUTH_KEY',   'p~T-449n2~G#DQpUX=H{_wbVF;jy;^L:S7##+o%5)c:)(nW68:rKt@o`w`Dlt`o*' );
define( 'LOGGED_IN_KEY',     'f7k.PriF fuVm<?DgU(Da4a|Sm1b JV]!M+0?.&5#_f>5jn$M5Ilgg)%Vl.b$_g|' );
define( 'NONCE_KEY',         '(Cl84{&Hu[l8Kl^~2kirIf`/x;LCbzdV/QrVpz;G/@oAu%nO!hL.2P3xte^s]?cz' );
define( 'AUTH_SALT',         'S9b@*A(R:b$EfjN4<NZU:_onrS+zvO2fRo(PcVUT?1yqx.WP&N;^MP#^U lH7NCb' );
define( 'SECURE_AUTH_SALT',  'KB<}GehrzBvQvQ`R-$(IvhB_[{>2+p47SeD`-k;wjyUb(n^6p60!<fb5I;?l8zX8' );
define( 'LOGGED_IN_SALT',    'Atfmu4^G+7B/@;=iD%Md&`2TbvZ+W[T:B>/j+~ME]GEWFHmmyLG,{+M+lZn{p!Z(' );
define( 'NONCE_SALT',        'R{+^,&cu4Ac2R<)l&yN<a<Fs9SE=KpfFEgl<l.-zH.`ox}#v`V#>&=r_{1FuDS1u' );
define( 'WP_CACHE_KEY_SALT', 'c8Fr!kSinN{N6hYL]z$9nK~JY&nAok@]CTAlfJ=0@]Xi_j,)Q1uC[t)V/9Any*?|' );


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

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
