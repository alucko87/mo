<?php
define('DEBUG', false);

define('BASE_ADDRESS', 'http://'.$_SERVER['SERVER_NAME'].'/');

define('DB_NAME', 'u980266495_mo');
define('DB_USER_NAME', 'u980266495_artem');
define('DB_PASSWORD',  'm260587');
define('vk_client_id', '4514115');
define('vk_client_secret', '96ZFgmsgUHU0khRncGKB');
define('vk_redirect_uri', 'http://'.$_SERVER['SERVER_NAME'].'/register.html?provider=vk&scope=email');
define('vk_replased_uri', 'http://'.$_SERVER['SERVER_NAME'].'/cabinet.html?provider=vk');
define('vk_url', 'http://oauth.vk.com/authorize');
define('vk_url_access', 'https://oauth.vk.com/access_token');
define('vk_api', 'https://api.vk.com/method/users.get');
define('vk_username', 'user_id');
define('fb_client_id', '1410176639298464');
define('fb_client_secret', '91a06a6ec5c0c26417f9ad2ce0877482');
define('fb_redirect_uri', 'http://'.$_SERVER['SERVER_NAME'].'/register.html?provider=fb&scope=email');
define('fb_replased_uri', 'http://'.$_SERVER['SERVER_NAME'].'/cabinet.html?provider=fb');
define('fb_url', 'https://www.facebook.com/dialog/oauth');
define('fb_url_access', 'https://graph.facebook.com/oauth/access_token');
define('fb_api', 'https://graph.facebook.com/me');
define('fb_username', 'i');
define('li_client_id', '77c7exr4teas6r');
define('li_client_secret', 'jVf1qGcz7rQ4GkPl');
define('li_redirect_uri', 'http://'.$_SERVER['SERVER_NAME'].'/register.html?provider=li');
define('li_replased_uri', 'http://'.$_SERVER['SERVER_NAME'].'/cabinet.html?provider=li');
define('li_url', 'https://www.linkedin.com/uas/oauth2/authorization');
define('li_url_access', 'https://www.linkedin.com/uas/oauth2/accessToken');
define('li_api', 'https://api.linkedin.com/v1/people/');
define('li_username', 'id');
define('od_client_id', '1127098880');
define('od_client_secret', 'B26F4B8F8374C69093945CCB');
define('od_redirect_uri', 'http://'.$_SERVER['SERVER_NAME'].'/register.html?provider=od');
define('od_replased_uri', 'http://'.$_SERVER['SERVER_NAME'].'/cabinet.html?provider=od');
define('od_url', 'http://www.odnoklassniki.ru/oauth/authorize');
define('od_url_access', 'http://api.odnoklassniki.ru/oauth/token.do');
define('od_api', 'http://api.odnoklassniki.ru/fb.do');
define('od_username', 'user_id');
define('tw_client_id', 'BlWmiyHU4zYZFVHxrMnRYB0xN');
define('tw_client_secret', 'eMXgHAfjCx02ML4Ut8PMu8TwracITCVuI6bU6NOmUU6A8WA23b');
define('tw_redirect_uri', 'http://'.$_SERVER['SERVER_NAME'].'/register.html?provider=tw');
define('tw_replased_uri', 'http://'.$_SERVER['SERVER_NAME'].'/cabinet.html?provider=tw');
define('tw_url', 'https://api.twitter.com/oauth/request_token');
define('tw_url_access', 'https://api.twitter.com/oauth/access_token');
define('tw_api', 'https://api.twitter.com/oauth2/token');
define('go_client_id', '721710723622-9pl5pgdqi4hprb3crrn0ac6dv69dk2ag.apps.googleusercontent.com');
define('go_client_secret', 'CP4GFjJNFQ_L0frj-SX5h4Pn');
define('go_redirect_uri', 'http://'.$_SERVER['SERVER_NAME'].'/register.html?provider=go');
define('go_replased_uri', 'http://'.$_SERVER['SERVER_NAME'].'/cabinet.html?provider=go');
define('go_url', 'https://accounts.google.com/o/oauth2/auth');
define('go_url_access', 'https://accounts.google.com/o/oauth2/token');
define('go_api', 'https://www.googleapis.com/oauth2/v1/userinfo');
define('go_username', 'id');

function db_mysql_connect()
{
    $link = mysql_connect('mysql.hostinger.com.ua', DB_USER_NAME, DB_PASSWORD)
    	or die('Could not connect to MySQL');

    mysql_select_db(DB_NAME)
    	or die('Could not connect to database');

    mysql_query('SET NAMES utf8', $link);

    return $link;
}

function db_name()
{
	$db_name=DB_NAME;
	return $db_name;
}
?>
