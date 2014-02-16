<?php

$fromname = "Admin";
$fromemail = "admin@domain.com";
$subject = "Hello World!";
$body = "Hi [name],<br/><br/>This is a test mail.<br/><br/>Admins";
$res = DB::findAllFromQuery("select * from mass_mailer_queue");

function getContentAfterReplacing($content, $data) {
    $matches = array();
    preg_match_all("/\[([A-Za-z]*)\]/", $content, $matches, PREG_SET_ORDER);
    foreach ($matches as $match) {
        if (!in_array($match[1], array_keys($data))) {
            $data[$match[1]] = "";
        }
        $content = str_replace($match[0], $data[$match[1]], $content);
    }
    return $content;
}

$data = array();
foreach ($res as $value) {
    if (!PHPB::isValidEmail($value['email'])) {
        DB::update("mass_mailer_queue ", array("status" => "error-format", "updatedOn" => data("Y-m-d H:i:s")), "id=" . $value['id']);
        continue;
    }
    $d = array();
    $d['toemail'] = $value['email'];
    $d['toname'] = ucwords(strtolower(trim($value['name'], " \"\',;")));
    $d['fromemail'] = $fromemail;
    $d['fromname'] = $fromname;
    $d['subject'] = $subject;
    $d['body'] = getContentAfterReplacing($body, array("name" => $value['toname']));
    $d['idData'] = $value['id'];
    $data[] = $d;
}

function receiveCallback($response, $info, $request) {
    if ($info['http_code'] == 200) {
        DB::update("mass_mailer_queue ", array("responseText" => print_r($response, TRUE), "status" => "sent", "updatedOn" => data("Y-m-d H:i:s")), "id=" . $request->idData);
    } else {
        DB::update("mass_mailer_queue ", array("responseText" => print_r($response, TRUE), "status" => "error-sending", "updatedOn" => data("Y-m-d H:i:s")), "id=" . $request->idData);
    }
}

AmazonBatchMail::send($data, "receiveCallback");
