<?php

require_once INCLUDES_DIR . 'ErrorHandler.php';

/**
 * PHPB - Collection of helper functions
 * @package PHPBoilerplate
 * @author: Siddhartha Sahu <me@siddharthasahu.in>
 */
class PHPB extends ErrorHandler {

    /**
     * Send a 'location: url' header and exit immediately.
     * Note: This will not work if the page has already sent some output.
     * @param string $url Url
     * @return void
     */
    public static function redirectToURLandExit($url) {
        header("Location:" . $url);
        exit(0);
    }

    /**
     * Write data to filename
     * @param string $filename The name of file
     * @param string $data The data to write
     * @param string $mode Mode of file write. Default is to append to file.
     * @return bool
     */
    public static function writeToFile($filename, $data, $mode = "a+") {
        try {
            $file = fopen($filename, $mode);
            if ($file) {
                fputs($file, date("[Y-m-d H:i:s]\n") . $data
                    . "\n======================================================================\n");
                fclose($file);
                return TRUE;
            }
        } catch (Exception $e) {
            self::handleError("Error writing to file", $e);
        }
        return FALSE;
    }

    /**
     * Check an email address
     * @param string $email The email address to check
     * @return bool
     */
    public static function isValidEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Display the data nicely in a browser
     * @param mixed $data The data to print
     * @param bool $withType Indicate if data type are also to be printed
     * @return void
     */
    public static function prettyPrint($data, $withType = FALSE) {
        echo "<pre>";
        $withType ? var_dump($data) : print_r($data);
        echo "</pre>";
    }

    /**
     * Get session data if exists and unset it. Support extracting individual values from an array.
     * @param string $name1 Extracts and unsets $_SESSION[$name1]
     * @param string $name2 Extracts and unsets $_SESSION[$name1][$name2]
     * @return string
     */
    public static function getSessionData($name1, $name2 = null) {
        if (isset($_SESSION[$name1])) {
            if ($name2 != null) {
                if (isset($_SESSION[$name1][$name2])) {
                    $data = $_SESSION[$name1][$name2];
                    unset($_SESSION[$name1][$name2]);
                } else {
                    $data = "";
                }
            } else {
                $data = $_SESSION[$name1];
                unset($_SESSION[$name1]);
            }
        } else {
            $data = "";
        }
        return $data;
    }

}
