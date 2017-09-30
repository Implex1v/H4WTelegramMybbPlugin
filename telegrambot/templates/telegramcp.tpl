<html>
    <head>
        <title>Telegram Bot CP</title>
        {$headerinclude}
        <link rel="stylesheet" href="cache/themes/theme1/usercp.css"/>
    </head>
    <body>
        {$header}
        <table width="100%" border="0" align="center">
            <tr>
                {$usercpnav}
                <td valign="top">
                    {$telegramCPWarning}
                    <table border="0" cellspacing="{$theme['borderwidth']}" cellpadding="{$theme['tablespace']}" class="tborder">
                        <tr>
                            <td class="thead" colspan="2"><strong>Telegram Bot Einstellungen</strong></td>
                        </tr>
                        <tr>
                            <td width="50%" class="trow1" valign="top">
                                <fieldset class="trow2">
                                    <legend>
                                        <strong>Informationen</strong>
                                    </legend>
                                    <table cellspacing="0" cellpadding="2">
                                        <tr>
                                            <td>
                                                <span>User ID</span>
                                            </td>
                                            <td>
                                                {$tgbSettings['user_id']}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span>Telegram ID</span>
                                            </td>
                                            <td>
                                                {$tgbSettings['telegram_id']}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span>Bot Token</span>
                                            </td>
                                            <td>
                                                {$tgbSettings['token']}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span>Aktiv</span>
                                            </td>
                                            <td>
                                                {$tgbSettings['active']}
                                            </td>
                                        </tr>
                                    </table>
                                </fieldset>
                            </td>
                            <td width="50%" class="trow1" valign="top">
                                <fieldset class="trow2">
                                    <legend>
                                        <strong>Einstellungen</strong>
                                    </legend>
                                    <form action="telegrambot.php?action=save" method="post">
                                        <table cellspacing="0" cellpadding="2">
                                            <tr>
                                                <td colspan="2">
                                                    <span class="smalltext">Benarchrichtigung bei neuen privaten Nachrichten:</span>
                                                </td>
                                                <td colspan="2">
                                                    <select name="show_pm">
                                                        <option value="0" {$showPM0}>Aus</option>
                                                        <option value="1" {$showPM1}>Ein</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <span class="smalltext">Benachrichtigung bei neuen Posts in allen Threads:</span>
                                                </td>
                                                <td colspan="2">
                                                    <select name="show_all_posts">
                                                        <option value="0" {$showAllPosts0}>Aus</option>
                                                        <option value="1" {$showAllPosts1}>Ein</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="submit" class="button" value="Speichern" />
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                </fieldset>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        {$footer}
    </body>
</html>