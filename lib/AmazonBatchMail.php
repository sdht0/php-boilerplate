<?php

require INCLUDES_DIR . "external/RollingCurl.php";

/**
 * AmazonBatchMail - Send multiple mails using Amazon SES in parallel
 * @package PHPBoilerplate
 * @author: Siddhartha Sahu <me@siddharthasahu.in>
 */
class AmazonBatchMail {

    private static $results;
    private static $count;

    /**
     * Send multiple mails
     * @param $data It should be a 2D array, with each entry containing values for toname, toemail, fromemail, fromname, subject and body
     * @param $callback function called at the end of sending individual mails
     */
    public static function send($data, $callback = "AmazonBatchMail::request_callback") {

        self::$results = array();
        self::$count = 0;

        $url = "https://email.us-east-1.amazonaws.com/";
        $rc = new RollingCurl($callback);

        foreach ($data as $tomail) {
            if (!isset($tomail['toname'], $tomail['toemail'], $tomail['from'], $tomail['fromname'], $tomail['subject'], $tomail['body'])) {
                continue;
            }

            $to = $tomail['toname'] == "" ? $tomail['toemail'] : $tomail['toname'] . " <" . $tomail['toemail'] . ">";
            $from = $tomail['fromname'] == "" ? $tomail['fromemail'] : $tomail['fromname'] . " <" . $tomail['fromemail'] . ">";
            $subject = $tomail['subject'];
            $body = $tomail['body'];

            $date = gmdate('D, d M Y H:i:s e');
            $ekey = base64_encode(hash_hmac('sha1', $date, AWS_SECRET, true));
            $headers = array();
            $headers[] = "Host: email.us-east-1.amazonaws.com";
            $headers[] = "Content-Type: application/x-www-form-urlencoded";
            $headers[] = "Date: " . $date;
            $headers[] = "X-Amzn-Authorization: AWS3-HTTPS AWSAccessKeyId=" . AWS_KEY . ",Algorithm=HmacSHA1,Signature=" . $ekey;
            $postdata = "Action=SendEmail&Source=" . urlencode($from) . "&Destination.ToAddresses.member.1=" . urlencode($to) . "&Message.Subject.Data=" . urlencode($subject) . "&Message.Body.Html.Data=" . urlencode($body);

            $request = new RollingCurlRequest($url);
            $request->options = array(CURLOPT_POSTFIELDS => $postdata,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HEADER => false,
                CURLOPT_RETURNTRANSFER => true);
            $request->toEmail = $tomail['email'];
            $request->idData = isset($tomail['idData']) ? $tomail['idData'] : "";
            $rc->add($request);
            self::$count++;
        }
        $rc->execute();
        return self::$count;
    }

    /**
     * Default callback function. All responses are stored for later retrieval.
     */
    public static function request_callback($response, $info, $request) {
        self::$results[$request->toEmail] = array("code" => $info['http_code'], "idData" => $request->idData);
    }

    /**
     * Get all results if default callback function is used.
     */
    public static function getResults() {
        $waitcount = 0;
        $maxcount = self::$count * 3;
        while (count(self::$results) < self::$count) {
            sleep(1);
            $waitcount++;
            if ($waitcount > $maxcount) {
                break;
            }
        }
        return self::$results;
    }

}
