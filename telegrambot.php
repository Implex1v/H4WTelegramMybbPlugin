<?php
ini_set('display_errors', 1);
// Disallow direct access to this file for security reasons
if (!defined("IN_MYBB")) {
    die("Direct initialization of this file is not allowed.");
}

require "telegrambot/Logger.php";
require_once MYBB_ROOT."/inc/adminfunctions_templates.php";

$plugins->add_hook("member_do_register_end", "handleNewUser", "5");
$plugins->add_hook("datahandler_post_insert_post_end", "handleNewPost", "5");
$plugins->add_hook("datahandler_pm_insert_end","handleNewPrivateMessage", "5");
$plugins->add_hook("global_start","handleUserCPMenu","");

function telegrambot_info() {
    return array("name" => "MyBB Telegram Bot", "description" => "MyBB Telegram Bot für h4w-rpg.de", "website" => "https://implex1v.de", "author" => "Implex1v", "authorsite" => "https://implex1v.de", "version" => "1.0", "guid" => "", "codename" => str_replace('.php',
        '', basename(__FILE__)), "compatibility" => "*");
}

function telegrambot_install() {
    global $db;

    $db->query("CREATE TABLE mybb_telegrambot_user (id INT PRIMARY KEY AUTO_INCREMENT, user_id INT, telegram_id INT, token VARCHAR(255), active TINYINT, show_pm TINYINT DEFAULT 1, show_all_posts TINYINT DEFAULT 0);");
}

function telegrambot_is_installed() {
    global $db;

    return $db->table_exists("telegrambot_user");
}

function telegrambot_uninstall() {
    global $db;

    $db->drop_table("telegrambot_user");
}


function telegrambot_activate() {
    global $db;

    $result = $db->simple_select("users", "uid");
    while($row = $db->fetch_array($result)) {
        $data = array(
            "user_id" => $row['uid'],
            "token" => getRandomString(50),
            "telegram_id" => 0,
            "active" => 0
        );

        $db->insert_query("telegrambot_user", $data);
    }

    find_replace_templatesets("usercp_nav", '#' . preg_quote('{$usercpmenu}') . '#', "{\$usercpmenu}\n\t{\$telegramBotSettings}");

    tgBotLoadTemplates();
}

function telegrambot_deactivate() {
    global $db;

    $db->delete_query("templates", "title = 'usercp_nav_telegrambot'");
    $db->delete_query("telegrambot_user");
    find_replace_templatesets("usercp_nav", '#' . preg_quote('{$telegramBotSettings}') . '#', "");
}

function getRandomString($length) {
    $token = "abcdefghijklmonpqrstuvwxyzABCDEFGHIJKLMNOPQRTSTUVWXYZ1234567890";
    $charactersLength = strlen($token);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $token[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}

function handleNewUser($data) {
    global $logger;

    $logger->log("handleNewUser() " . print_r($data, true));
}

function handleNewPost($data) {
    $post_payload = http_build_query(
        array(
            "pid" => $data->pid
        )
    );

    $opts = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $post_payload
        )
    );

    $context = stream_context_create($opts);
    $result = file_get_contents("https://api.implex1v.de/h4wbot.php?action=pollPosts", false, $context);

    $logger = new Logger("telegrambot.php");
    $logger->log("handleNewPost() Return value for pid ".$data->pid. " is ".$result);
}

function handleNewPrivateMessage($data) {
    $post_payload = http_build_query(
        array(
            "pmid" => $data->pmid[0]
        )
    );

    $opts = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $post_payload
        )
    );

    $context = stream_context_create($opts);
    $result = file_get_contents("https://api.implex1v.de/h4wbot.php?action=pollPrivateMessage", false, $context);

    $logger = new Logger("telegrambot.php");
    $logger->log("handleNewPrivateMessage() Return value for pmid ".$data->pmid. " is ".$result);
}

function tgBotLoadTemplates() {
    require __DIR__ . "/telegrambot/TemplateLoader.php";
    global $db;
    $laoder = new TemplateLoader();

    $template = $laoder->load("usercp_nav_telegrambot");
    $data = array(
        "title" => "usercp_nav_telegrambot",
        "template" => $db->escape_string($template),
        "sid" => -1,
        "version" => "",
        "dateline" => time()
    );
    $db->insert_query("templates", $data);
}

function handleUserCPMenu() {
    global $templates, $telegramBotSettings;
    $telegramBotSettings = eval($templates->render('usercp_nav_telegrambot'));
    //file_put_contents("benis.log", $telegramBotSettings, FILE_APPEND);
}