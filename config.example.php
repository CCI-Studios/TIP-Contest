<?php
if ($_SERVER['HTTP_HOST'] == 'toenailfungusinformationprogram.ca' || $_SERVER['HTTP_HOST'] == 'programmedinformationmycosedesonglesdorteil.ca')
{
    define('MYSQL_DSN', 'mysql:host=localhost;dbname=tip_contest');
    define('MYSQL_USER', '');
    define('MYSQL_PASS', '');
}
else if ($_SERVER['HTTP_HOST'] == 'tip.ccistaging.com')
{
    define('MYSQL_DSN', 'mysql:host=localhost;dbname=staging_tip');
    define('MYSQL_USER', '');
    define('MYSQL_PASS', '');
}
else
{
    define('MYSQL_DSN', 'mysql:host=localhost;dbname=tip_contest');
    define('MYSQL_USER', '');
    define('MYSQL_PASS', '');
}

define('MAILCHIMP_API_KEY', '');
define('MAILCHIMP_LIST_ID', '');
?>