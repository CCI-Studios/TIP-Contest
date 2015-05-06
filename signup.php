<?php
//honeypot
if ($_POST['website']) exit;

require('config.php');

$db = new PDO(MYSQL_DSN, MYSQL_USER, MYSQL_PASS);

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$address = $_POST['address'];
$city = $_POST['city'];
$province = $_POST['province'];
$postal_code = $_POST['postal_code'];
$telephone = $_POST['telephone'];
$email = $_POST['email'];
$date_of_birth = $_POST['date_of_birth'];
$receive_info = (int)isset($_POST['receive_info']);
$receive_guide = (int)isset($_POST['receive_guide']);
$lang = $_POST['lang'];

$query = $db->prepare('INSERT INTO entry (
        date_added, 
        first_name, 
        last_name, 
        address, 
        city, 
        province, 
        postal_code, 
        telephone, 
        email, 
        date_of_birth, 
        receive_info, 
        receive_guide,
        lang
    ) 
    VALUES (
        :date_added, 
        :first_name, 
        :last_name, 
        :address, 
        :city, 
        :province, 
        :postal_code, 
        :telephone, 
        :email, 
        :date_of_birth, 
        :receive_info, 
        :receive_guide,
        :lang
    )');
$query->bindParam(':date_added', date('Y-m-d H:i:s'));
$query->bindParam(':first_name', $first_name);
$query->bindParam(':last_name', $last_name);
$query->bindParam(':address', $address);
$query->bindParam(':city', $city);
$query->bindParam(':province', $province);
$query->bindParam(':postal_code', $postal_code);
$query->bindParam(':telephone', $telephone);
$query->bindParam(':email', $email);
$query->bindParam(':date_of_birth', $date_of_birth);
$query->bindParam(':receive_info', $receive_info);
$query->bindParam(':receive_guide', $receive_guide);
$query->bindParam(':lang', $lang);

$query->execute();

require_once('MailChimp.php');
$mc = new \Drewm\MailChimp(MAILCHIMP_API_KEY);
$result = $mc->call('lists/subscribe', array(
    'id' => MAILCHIMP_LIST_ID,
    'email' => array('email'=>$email),
    'merge_vars' => array(
        'FNAME'=>$first_name, 
        'LNAME'=>$last_name, 
        'CTYPE'=>'Written', 
        'CDATE'=>date('Y-m-d'), 
        'COMMENTS'=>'Signed up on the TIP Contest website.',
        'LANG' => $lang
    ),
    'double_optin' => false,
    'send_welcome' => false
));
?>