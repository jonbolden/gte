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
// For local development - make sure to add wp-config.local.php to your .gitignore file - this file should NOT be on the production server


// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'gte');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

define('WP_CACHE', true);


/**
* For developers: WordPress debugging mode.
*
* Change this to true to enable the display of notices during development.
* It is strongly recommended that plugin and theme developers use WP_DEBUG
* in their development environments.
*/
define('WP_DEBUG', false);

define('SAVEQUERIES', true);

/**
* WordPress Database Table prefix.
*
* You can have multiple installations in one database if you give each a unique
* prefix. Only numbers, letters, and underscores please!
*/
$table_prefix  = 'wp_'; 




/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@-*/

/**#@+
* Authentication Unique Keys and Salts.
*
* Change these to different unique phrases!
* You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
* You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
*
* @since 2.6.0
*/


define('AUTH_KEY',         '!9u^<,gh.u86~5Z% &sn=]%_|z#,L2D(iqu5!z.x$+-BUz<(y?<_n1A )HFG}Si9');
define('SECURE_AUTH_KEY',  'nd80=R$+9xW*6m.dU9iZ(Z[hHVT$;7:Dmk>apotp+kCX|7oE}F+;fQZ]NtM~V EK');
define('LOGGED_IN_KEY',    '48SMuK]XG&r0{?>cc_9~rgr$tLu*gLG^7O^STXH)uKpuiF{|5K>;2=7D>%E[[{:z');
define('NONCE_KEY',        'ARul~h+khD&xj!mq1lC2uyX~&#pb!S<nG<O6h$:iB!epvB)j,x)2.}{8S-L=2Y2b');
define('AUTH_SALT',        'XPi,1kqx25UEl(Zc!KDz%b(|2{6h}7+FWVUM!.UewaZ(Rm.[Gxrt@ZYt[NcDR*6R');
define('SECURE_AUTH_SALT', 'Zb|f5K+i,6jn@YM``z:}al_dby1ToVXi;l^v)N/C~yZfc9%a++|xt(OV{a/cPyKX');
define('LOGGED_IN_SALT',   'XS+4&>|!R+?%;iLeqh#Q66yA<phe66.l3-?Jl9{s[q.)g#~$cC`7x{k^?Y#W-|(Y');
define('NONCE_SALT',       'GmZ(C(Pr2c.H^)?juR#1h_bTP2f/PM8vS2l+5#,F//|O8o&rRc&Ci}eXt$L@.%m9');


/**
* WordPress Localized Language, defaults to English.
*
* Change this to localize WordPress. A corresponding MO file for the chosen
* language must be installed to wp-content/languages. For example, install
* de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
* language support.
*/
define('WPLANG', '');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
  define('ABSPATH', dirname(__FILE__) . '/');

  /** Sets up WordPress vars and included files. */
  require_once(ABSPATH . 'wp-settings.php');
