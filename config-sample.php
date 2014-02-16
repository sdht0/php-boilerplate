<?php

/**
 * Define whether to display errors. Set to TRUE on development servers.
 */
define("DEBUG", FALSE);

/**
 * Define error reporting level. Set to E_ALL | E_STRICT on development servers.
 */
error_reporting(E_ERROR);

/**
 * function to change display_error settings.
 */
function displayErrors($option = true) {
    if ($option) {
        ini_set('display_errors', '1');
    } else {
        ini_set('display_errors', '0');
    }
}

displayErrors(DEBUG);

/**
 * Most of the pages will require session handling. Start session by default here.
 */
session_start();

/**
 * Set session limit
 */
session_set_cookie_params(60 * 60 * 6); //6 hours

date_default_timezone_set("Asia/Kolkata");
define("ZONE_OFFSET", "+0530");

define("SITE_URL", "http://example.com/");

/**
 * Define various paths for later use. Add your own paths here.
 */
define("JS_URL", SITE_URL . "js/");
define("CSS_URL", SITE_URL . "css/");
define("IMAGE_URL", SITE_URL . "img/");

define("SITE_DIR", dirname(__FILE__) . "/");
define("INCLUDES_DIR", SITE_DIR . "lib/");

/**
 * Database connection details.
 */
define("SQL_HOST", "localhost");
define("SQL_PORT", "3306");
define("SQL_USER", "dbuser");
define("SQL_PASS", "dbpass");
define("SQL_DB", "dbname");

/**
 * Mail server details
 */
define("MAIL_PATH", "Mail.php");
define("MAIL_USER", "user@domain.com");
define("MAIL_PASS", "pass");
define("MAIL_HOST", "");    // ssl://smtp.gmail.com
define("MAIL_PORT", "");    // 465


/**
 * AWS connection details.
 */
define("AWS_KEY", "");
define("AWS_SECRET", "");

/**
 * File to log errors
 */
define("ERROR_LOG", dirname(__FILE__) . "/errors.log");

/**
 * Include the following by default on each page.
 */
include INCLUDES_DIR . 'PHPB.php';
include INCLUDES_DIR . 'DB.php';
