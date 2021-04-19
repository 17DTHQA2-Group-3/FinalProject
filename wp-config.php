<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'a' );

/** MySQL database username */
define( 'DB_USER', 'a' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '3H}(NkrA7`1ipa}w2frU;&q{i62e( ?/gV7kANwa<E0}w-a?]c4eV9=e:5dq?-* ' );
define( 'SECURE_AUTH_KEY',  'H#*?5{fY`^ut;S;%oAv0A!f.4_X1x*!5l447E_}>}*j_`tD<WrqEqGv^vvxX86oV' );
define( 'LOGGED_IN_KEY',    ' X~tcp|1q)p>IxD|mTQ1WNS)iMU,$ux|+$#ZX,R#bvvJ2`qOiHZiz`zS;@jG>$@;' );
define( 'NONCE_KEY',        'AfGkOh~[t:AeB21u0lx{ _k2n?7pLQ[]3<_M~]@t>hW7!<*|RQOuQ_c_VIMW%lL1' );
define( 'AUTH_SALT',        '[w&X&] &pMUo `*XMJ2g4WeV>~ pJL5-ujB`|3PJUC<Qo/e6eqb&+_8JX}=f!al(' );
define( 'SECURE_AUTH_SALT', 'k(*dH+MZ.O&J/]w=L;0Lv1u [_WS6p9E$|(mR8aK7iC!FAP1M%5M<&k5% HocIS@' );
define( 'LOGGED_IN_SALT',   '1Yd&j174*#7&axpB(AXMVi:h7G8dVX`1Wa%@9XZ@4Bixb;skT@n&-^m1j-UHp{m(' );
define( 'NONCE_SALT',       'U1()CY0gmv,OGxDd ^7m* =$.kP~^SBj1beQ{l#4G`G,}`K6sawBXB*P1hq!E2<I' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
