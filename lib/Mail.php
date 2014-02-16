<?php

require INCLUDES_DIR . "external/class.phpmailer.php";
require_once INCLUDES_DIR . 'ErrorHandler.php';

/**
 * Mail - Helper class to send mails using PHPMailer
 * @package PHPBoilerplate
 * @author: Siddhartha Sahu <me@siddharthasahu.in>
 */
class Mail extends ErrorHandler {

    /**
     * Optional SMTP debugging. If enabled, outputs debugging information in HTML format
     * 0 = output off (for production use)
     * 1 = ouput client messages
     * 2 = output both client and server messages
     * @type int
     */
    public static $SMTPDebug = 0;

    /**
     * Send a single mail
     */
    public static function sendMail($subject, $body, $to, $toname, $from, $fromname) {
        try {
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->SMTPDebug = self::$SMTPDebug;
            $mail->Debugoutput = 'html';
            $mail->Host = MAIL_HOST;
            $mail->Port = MAIL_PORT;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            $mail->Username = MAIL_USER;
            $mail->Password = MAIL_PASS;
            $mail->setFrom($from, $fromname);
            $mail->addReplyTo($from, $fromname);
            $mail->addAddress($to, $toname);
            $mail->Subject = $subject;
            $mail->msgHTML($body);
            if ($mail->send()) {
                return TRUE;
            }
        } catch (Exception $e) {
            self::handleError("Error sending mail to '$to'", $e);
        }
        return FALSE;
    }

}
