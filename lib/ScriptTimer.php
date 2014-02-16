<?php

/**
 * ScriptTimer - Track script execution time
 * @package PHPBoilerplate
 * @author: Siddhartha Sahu <me@siddharthasahu.in>
 */
class ScriptTimer {

    public static $starttime = NULL;
    public static $endtime = NULL;

    /**
     * Start tracking time
     * @return void
     */
    public static function startTimer() {
        $mtime = microtime();
        $mtime = explode(" ", $mtime);
        $mtime = $mtime[1] + $mtime[0];
        self::$starttime = $mtime;
    }

    /**
     * Stop tracking time and return result
     * @return int execution time in seconds
     */
    public static function stopTimerAndGetTime() {

        if (self::$starttime == NULL) {
            return -1;
        }

        $mtime = microtime();
        $mtime = explode(" ", $mtime);
        $mtime = $mtime[1] + $mtime[0];
        $endtime = $mtime;
        self::$endtime = $mtime;
        return (self::$endtime - self::$starttime);
    }

}
