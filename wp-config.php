<?php
/**
 * WordPress の基本設定
 *
 * このファイルは、インストール時に wp-config.php 作成ウィザードが利用します。
 * ウィザードを介さずにこのファイルを "wp-config.php" という名前でコピーして
 * 直接編集して値を入力してもかまいません。
 *
 * このファイルは、以下の設定を含みます。
 *
 * * MySQL 設定
 * * 秘密鍵
 * * データベーステーブル接頭辞
 * * ABSPATH
 *
 * @link https://ja.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// 注意:
// Windows の "メモ帳" でこのファイルを編集しないでください !
// 問題なく使えるテキストエディタ
// (http://wpdocs.osdn.jp/%E7%94%A8%E8%AA%9E%E9%9B%86#.E3.83.86.E3.82.AD.E3.82.B9.E3.83.88.E3.82.A8.E3.83.87.E3.82.A3.E3.82.BF 参照)
// を使用し、必ず UTF-8 の BOM なし (UTF-8N) で保存してください。

// ** MySQL 設定 - この情報はホスティング先から入手してください。 ** //
/** WordPress のためのデータベース名 */
define( 'DB_NAME', 'carpemita_wp2' );

/** MySQL データベースのユーザー名 */
define( 'DB_USER', 'carpemita_wp2' );

/** MySQL データベースのパスワード */
define( 'DB_PASSWORD', 'e5y0gsyklq' );

/** MySQL のホスト名 */
define( 'DB_HOST', 'mysql10035.xserver.jp' );

/** データベースのテーブルを作成する際のデータベースの文字セット */
define( 'DB_CHARSET', 'utf8' );

/** データベースの照合順序 (ほとんどの場合変更する必要はありません) */
define( 'DB_COLLATE', '' );

/**#@+
 * 認証用ユニークキー
 *
 * それぞれを異なるユニーク (一意) な文字列に変更してください。
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org の秘密鍵サービス} で自動生成することもできます。
 * 後でいつでも変更して、既存のすべての cookie を無効にできます。これにより、すべてのユーザーを強制的に再ログインさせることになります。
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Nv[9!8yl8)`yf}a#@s}GT$sjN+TB.O+Rx+:@,[IKoYn{91C0s&%:8lB6enTd-jo3' );
define( 'SECURE_AUTH_KEY',  '$8:{ Q6:~ 0FpsP#9]U*>Q[th_$60*[WLY`|VfvtmB][P#EtG?P5Z7=:^%dkUiEZ' );
define( 'LOGGED_IN_KEY',    'u<R!< U=;a:S90 Ao-ldU[D2Qon|8D@3^/ok/Zw1$D[]U05!Q.>6l$9MFxMYh-Jc' );
define( 'NONCE_KEY',        '*WRF U3HxAsJn>bHhYe7@uMg>P?7i(^@4,`)Su()4FG0@<H $W^j3FQWfZIA8vlW' );
define( 'AUTH_SALT',        'h_#]K#$;$(OK3AJ$e=rdYEZNB[w9xVAV8WJODS?><F+v`H$J,=V @J^$Px7+VC-h' );
define( 'SECURE_AUTH_SALT', 'xLi+|s/]-H(m9M{pq@5.WA[AUJk%tr0vM#~k)zrUpv*p,hR~9==}]6rg9y6=$0ou' );
define( 'LOGGED_IN_SALT',   'm_L*mlp0[*NQ6Q*eYn(Jj-V<IV+lBqYMG@ SYGOCS2W^ECkvf}=FnrgtDae{<)mf' );
define( 'NONCE_SALT',       'Ot_(Ru2GqqzH<2-~zMM.zjL$~0#lAJ9q6I3t[xq0ZXG!?Da`x|isC/K<YSXW~y=e' );
define( 'WP_CACHE_KEY_SALT','/fITly7aZo70<o5` j)f9A8*tiWr$@ZGM&_tvr:wr.MI+4HVHP4({n-Hd{@XyipG' );

/**#@-*/

/**
 * WordPress データベーステーブルの接頭辞
 *
 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を
 * インストールすることができます。半角英数字と下線のみを使用してください。
 */
$table_prefix = 'wp_';

/**
 * 開発者へ: WordPress デバッグモード
 *
 * この値を true にすると、開発中に注意 (notice) を表示します。
 * テーマおよびプラグインの開発者には、その開発環境においてこの WP_DEBUG を使用することを強く推奨します。
 *
 * その他のデバッグに利用できる定数についてはドキュメンテーションをご覧ください。
 *
 * @link https://ja.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* カスタム値は、この行と「編集が必要なのはここまでです」の行の間に追加してください。 */



/* 編集が必要なのはここまでです ! WordPress でのパブリッシングをお楽しみください。 */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
