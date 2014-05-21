<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'sauces');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost:8888');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'u){DAN339|gi>euP50 &hRj8uh?5v{v)[8t QknSJNx~[7$5>QLvdv+Q!z=Ld!Wy');
define('SECURE_AUTH_KEY',  'q+26Q-^H_~$p[58Ac15@dz}:~]X_H&[+YI-BHpw/OU,Y2|cPM^qn)w-^gpkW-NWg');
define('LOGGED_IN_KEY',    'x1g_b,@7$<VfZ)kK{%Y3{-pg@Q#+#a M>|nx!dYPFyM[rN?y`(8Z,ZTCY5 #EB0]');
define('NONCE_KEY',        '}>.l/TOV>pZQb1D?17d2+y<WX8>!TCCUW2|EcsX`R-Tl-FZs|{#SlyA=K`5A_r&s');
define('AUTH_SALT',        '>4F4`j0v?L%*}{7fX*+/cmJ1P5cehkWa(-vK;@yHxOp39u(0S=sE!0qC%T9~zM]L');
define('SECURE_AUTH_SALT', 'D$Q6<6JGA7[ZiF1-o>nbyjf%)*3JQC*u8-DkUfI.nl:vFyiByA24W7Cu(#(t}PWN');
define('LOGGED_IN_SALT',   'Y<^6xI|SJ-XBa=l]qMe:#~VFaFW6S}VxYg&$j^{.rqG*3HGbj? rru^c-:3HCU+0');
define('NONCE_SALT',       'r}Mq=F+ZppN_bkrOf<xd&>e]m6`+(sO8Nz_6kJ[k`PUd1G_5ulhOI9$ag+x#4Uj%');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'sep_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
