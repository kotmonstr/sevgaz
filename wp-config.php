<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'sev_gaz' );

/** Имя пользователя MySQL */
define( 'DB_USER', 'root' );

/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', '1' );

/** Имя сервера MySQL */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'R|#+i7 vH1qF8ur>9~95;I5jVL[@D-tsPh9Ff/^|/=)gkJ~aMmsz{w[}xYvs`^a<' );
define( 'SECURE_AUTH_KEY',  '{,*)I>$Wb7|(fm:b?:($ ;.gzf4viA~O94v~`#9-^:o4$EDJ6-4[(4 ]`$j}g4Bd' );
define( 'LOGGED_IN_KEY',    ' =HFw=TEQ<C6PcHf=9c91k`&T_2b0!W0A<<%Xb;jImZy{>z;2K}<{&L0xws%#-Kj' );
define( 'NONCE_KEY',        '*zsa[q75D>[0O&nqiEcnZI#n*y|cGao38?I:o6n<}cT%h`qc(UgXX)I{v>7L40M7' );
define( 'AUTH_SALT',        ':DN64My4viZ=}ro~Stc7Ezp8#=uz{U(o%!zw]EI7nqkY$GJgA !>0]s$KI ynYMs' );
define( 'SECURE_AUTH_SALT', 'kd[7g2w>AXoLE`JE.gkF~).A&W=@EEjdkeu)xuK)C6h?7wV~*$Y?;?U*<bXmc8%B' );
define( 'LOGGED_IN_SALT',   'yz-9+Jk /,cy1e*oNJR&jG.y,jts&-#bre^AV[uS/J@_{o:H9QOXPgSZ,SU:|-GV' );
define( 'NONCE_SALT',       'q/y>%c3#ci!L(L.E,}pf2ZAtEIFGw:8GH^L,|5N9a*6|/3Z(zB.PLEc9b(enZ ~^' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once( ABSPATH . 'wp-settings.php' );

define('FS_METHOD','direct');

define( 'WP_HOME', 'http://sevgaz.loc' );
define( 'WP_SITEURL', 'http://sevgaz.loc' );
