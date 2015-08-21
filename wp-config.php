<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'soundkreationsfinal');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'P!+`Nd=FMBpQ1eaW+t*wunv;/Ljp-_&d^tE: @-7bcoJr<:jJM0W4oOUnYj}YuPq');
define('SECURE_AUTH_KEY',  'SI>r|-%lH{jL /xRr!y_2X8N&[tg|NHi@mMVFrJXZ!RC]M-$>*kJmD=ciso:h+ 1');
define('LOGGED_IN_KEY',    'IQjs68b&BVZdm|Y~D#JMYODDu d[y=]J<+gxB~FKF=#R+{Buz%/|KbA!y!<Xqk@>');
define('NONCE_KEY',        'ns-&zRH-43{`t4{ukWlL7[np+o&1 ~!9:7&H[+&%u7^TyB2x+V1uCH755AU&-(4$');
define('AUTH_SALT',        '1p4S Un[0z_idl|!WD 1>|iME*mVqGK3g3-%r!);]6p0G%gQ6Ve-T(iJu{NkoyO6');
define('SECURE_AUTH_SALT', 'Q4leK*;/Co*r-jUQT.{Q,_/R68{{n;lar=!!yU}2#b{ty*@F2;FmF$t}%:aWp1yl');
define('LOGGED_IN_SALT',   'F/v_-K -1A|37.[+4>:)M,fHjcw(8N-%`<%zQzG_C/1,-%G4d|`439+$?2d[2N+4');
define('NONCE_SALT',       'E(*;-|7m( 6/;@+X7zGs8dDHJLG_#DZ-a$mRrHl*x`aAR)[U+qO~/K^,_HF/ePv[');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
