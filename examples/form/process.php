<?php

require '../../config.php';

if (isset($_POST['formregister'])) {
    $data = $_POST['data'];
    if ($data['name'] == "" || $data['email'] == "" || $data['city'] == "") {
        $_SESSION['formdata'] = $data;
        $_SESSION['formmsg'] = "Missing data!";
    } else {
        //DB::insert("tablename", $data);
        $_SESSION['formmsg'] = "Registration successful!";
    }
    PHPB::redirectToURLandExit(SITE_URL . "examples/form");
}
PHPB::redirectToURLandExit(SITE_URL);
