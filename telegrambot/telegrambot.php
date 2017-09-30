<?php

define("IN_MYBB", 1);
define('THIS_SCRIPT', 'telegrambot.php');

require_once __DIR__ . "/global.php";
require_once __DIR__ . "/inc/functions_user.php";
$lang->load("misc");
add_breadcrumb('Telegram Bot Einstellungen', "telegrambot.php");

usercp_menu();

// Save data to database if the user has send the form
if($mybb->get_input('action') == "save") {
    $data = array(
        "show_pm" => $mybb->get_input('show_pm'),
        "show_all_posts" => $mybb->get_input('show_all_posts')
    );

    $db->update_query("telegrambot_user", $data, "user_id = ".$mybb->user['uid']);
}

$result = $db->simple_select("telegrambot_user", "*", "user_id = " . $mybb->user['uid']. ";");
if($result) {
    $tgbSettings = $db->fetch_array($result);
    $showPM0 = $tgbSettings['show_pm'] == 0 ? "selected" : "";
    $showPM1 = $tgbSettings['show_pm'] == 1 ? "selected" : "";

    $showAllPosts0 = $tgbSettings['show_all_posts'] == 0 ? "selected" : "";
    $showAllPosts1 = $tgbSettings['show_all_posts'] == 1 ? "selected" : "";
}

if($mybb->user['as_uid'] != 0) {
    $telegramCPWarning = eval($templates->render("telegramcp_warning"));
}


eval("\$page = \"".$templates->get("telegramcp")."\";");
output_page($page);

