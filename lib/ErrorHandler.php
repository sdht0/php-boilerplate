<?php

class ErrorHandler {

    /**
     * Holds information about the last error
     * @type array
     * @holds message, errorfile, errorobject
     */
    public static $lastError = NULL;

    /**
     * Store error messages and optionally write them to a log file
     * @param string $message Error message
     * @param ExceptionObject $e
     * @return void
     */
    protected static function handleError($message, $e = NULL) {
        $arr = array("message" => $message, "file" => "", "errorobject" => NULL);
        if ($e != NULL) {
            $arr = array("message" => $message . "; " . $e->getMessage(), "errorfile" => $e->getFile(), "errorobject" => $e);
            $message .= "\nInfo: " . $e->getMessage() . "\n" . $e->getFile();
        }
        self::$lastError = $arr;
        if (defined(ERROR_LOG)) {
            try {
                $file = fopen(ERROR_LOG, "a+");
                if ($file) {
                    fputs($file, date("[Y-m-d H:i:s] Error:\n") . $message . "\n\n");
                    fclose($file);
                }
            } catch (Exception $e) {
                
            }
        }
    }

}
