<?php

$types = array('seeker', 'employer');
include_once('0-includes.inc');
db_connect();

if (isset($_SESSION) && isset($_SESSION['panel_user_id']) && isset($_GET['type']) && in_array($_GET['type'], $types)) {
    $query = "SELECT * FROM $db_users where ruscable_user_id=" . intval($_SESSION['panel_user_id']);
    $rows = GetDB($query);
    if (isset($rows[0]) && $_GET['type'] != $rows[0]['type']) {
        mysql_query('UPDATE ' . $db_users . ' SET type="' . $_GET['type'] . '" where ruscable_user_id=' . intval($_SESSION['panel_user_id']));
    }
}

?>