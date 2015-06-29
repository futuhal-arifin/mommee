<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

define('WP_HOME','http://mommee.org');
define('WP_SITEURL','http://mommee.org');
define('WP_CACHE', false);
define('FTP_USER', 'k0449745' );
define('FTP_PASS', '09Dd5my4oG' );
define('FTP_HOST', '49.50.8.185' );


// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'k0449745__wp_mommee');

/** MySQL database username */
define('DB_USER', 'k0449745_mommee');

/** MySQL database password */
define('DB_PASSWORD', 'oibwtp7013');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'p#fi^!Z+UG-@6lqn6LJ`6S2dS/6RO6Ld}-,Ox6m/57]-_04S+vVO,C]hSD&=/Ca*');
define('SECURE_AUTH_KEY',  '-TN@A*+!p`^soZS[N5Vi,B+9U9-,%3fu[ih*_cY7aP(+(K4=nQ-FIlyi<`0X!yLd');
define('LOGGED_IN_KEY',    'oSn? |I@Y9*<e($:cwZ)gX,;F}37Hl[S|*+]Jj*?S:L8w!>3HvdN_ui@t*`w.(!%');
define('NONCE_KEY',        '@jNuNrTH*2)__cUu/]|T]6bW3$G]G#8t2^=o;0:Q2>zzq-E-IePskd2!ga%&-TO0');
define('AUTH_SALT',        'ccI&p,|c|V?BO;1DO_e]h!y-,YW2HG:w#Q1M~bh<th-Volt3wk-o1Dez3flTO<j(');
define('SECURE_AUTH_SALT', ']b:>;>2gcQQ=+b]dcd<c+nV.V9mkak;,7u3.Km7;@EuS%`-fB0@q_?_?,dn|PbKG');
define('LOGGED_IN_SALT',   'v3(BNVM[w@**|2|%#2i[>pSGu#w XB@7/sD(Y&/*)f{Q6f<I:Y `_<FO>kV^{G23');
define('NONCE_SALT',       '?4>c`v u{`ihgwAiSi,7H54OKEI 49(VkU<.=QfcK&nYP~mx|5q]t=(Dn=i7g3mo');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'mom_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
