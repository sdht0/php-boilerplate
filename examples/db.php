<?php

/**
 * Retrieve single row
 */
$r1 = DB::findOneFromQuery("select id,name,city from user where email=?", array("user@domain.com"));
if ($r1) {
    echo $r1['id'], $r1['name'], $r1['city'];
}

/**
 * Retrieve many rows
 */
$r2 = DB::findOneFromQuery("select id,city from cities");
if ($r2) {
    foreach ($r1 as $value) {
        echo $value['id'], $value['city'];
    }
}

/**
 * Insert a row
 */
$r3 = DB::insert("user", array("name" => "X", "email" => "u@d.c", "city" => "K"));
if ($r3) {
    echo DB::lastInsertId();
}

/**
 * Update a row
 */
$r4 = DB::update("user", array("name" => "Y"), "email=:email", array(":email" => "u@d.c"));
if (!$r4) {
    //Error
}
