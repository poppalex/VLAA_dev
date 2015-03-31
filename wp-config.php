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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'vlaa');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'N+j%zjl7D+g<[C`0M=@p:l%(KJFck1/0~*b-*qGm{)KPXS-R`-|C>]M(.Qef3-+a');
define('SECURE_AUTH_KEY',  'XNP&cf a91+#+jBTvbK.`-1xlbS{::t.,qagBkAqe>:T|6-.+_UvdZuzAl.4N-vM');
define('LOGGED_IN_KEY',    'q0xe1~^v&C0=yU,$dY|=&+|Q*Y{akt|AJzhl5(V~%o<eOI3)]`+@`;1LSP.S+i!^');
define('NONCE_KEY',        'EDne|E(v67^sw!-p/cI`[b%Mk|pG|%dR[l;8!q&U%-<X[5Nhgh52n*/KlOh-#D_j');
define('AUTH_SALT',        '46RQ}N7QOK|C;tp%?3IAG-Z|Ze{knsGe;eX=z{+aDn~g/-RIUjA5FT6{RQUo3vu3');
define('SECURE_AUTH_SALT', 'oX$ 2DHHpL/+qg4bU;JO,L=$4|T~yq:.rUH~8mWj*%?ren#e+m{&p%2[b&]K<fr~');
define('LOGGED_IN_SALT',   '_GiLqjk//pu+nq-$MnleSYNpUq|^|SPYFOBv~P:lT^3:CnB&!][:ZNx)tk*S_pp@');
define('NONCE_SALT',       ':F{:17Kk|T4r+;h7Cb{Z<+^v]$>fil]d43j]p]z1l!$Dc?Mb}NC- E<pR.Pz#4Vl');

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
