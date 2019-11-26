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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'peternakan');

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
define('AUTH_KEY',         'X,+Tv%A^|M+73z=jprhHh&OhktrI>.0pAk|&gNPb4*Y;A1s!.Ro0`;DsZvfg60H8');
define('SECURE_AUTH_KEY',  '}N)L*t4D&(/R-/^RmihC*H<9E5$EEV>QeVr*XCk@kmGhzZ?_#Kg6_0 a`Z7cS(._');
define('LOGGED_IN_KEY',    'e,47nW^mw(4V*)kJs4rH` Wk&e!FZ;gS6_Iw%h?3h*>(N3}p/:4hwR98!,t_}Y<N');
define('NONCE_KEY',        '~)74gTqw3IHKe!tg02DHJ=y,j(A)B2ZK!o@C%a}*ngr8ISpSYkW?Pnr@[S|n5b](');
define('AUTH_SALT',        'B1+WTG<%=&;;2_20_4 SAaxBf<{/#WOYY(f1YU1:yhfO.WrD]YWVFiibiWi22gU:');
define('SECURE_AUTH_SALT', '}4_D_gP5)S#62wgayW-i6PcX}gHCr-ca0|*MocTcRprPHDVmT|$D,Su5O)Etb`(r');
define('LOGGED_IN_SALT',   'KaW?pd%f-=^YO{DoFZ2ey.N_L77aBr`lD_(6BA[(3<@lW=pW=5M 0>Yv*`{(iT{0');
define('NONCE_SALT',       '_CI,->NPKs;eW&(EL9pV]y08xQJq#/hZV3L8OEYT.bjm<xA7(@:E?xI[UXdvKU*:');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'pp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
