<?php
//honeypot
if ($_POST['website']) exit;

require('config.php');

$db = new PDO(MYSQL_DSN . ';charset=utf8', MYSQL_USER, MYSQL_PASS);

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
$date = date('Y-m-d H:i:s');

if (!$first_name || !$last_name || !$address || !$city || !$province || !$postal_code || !$email || !$date_of_birth)
{
  echo json_encode(array('error'=>'required_fields'));
  exit;
}

$query = $db->prepare('SELECT * FROM entry WHERE email=:email');
$query->bindParam(':email', $email);
$query->execute();
if ($query->rowCount())
{
    echo json_encode(array('error'=>'email'));
    exit;
}

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
$query->bindParam(':date_added', $date);
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


require_once('vendor/autoload.php');


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


$sendgrid = new SendGrid(SENDGRID_USERNAME, SENDGRID_PASSWORD);
$message = new SendGrid\Email();
if ($lang == 'en')
{
    $subject = 'Welcome to TIP';
    $text = '
    Thank you for visiting nailfungus.ca and for signing up to the Toenail Fungus Information Program (TIP). We look forward to providing you with new and useful information to help you manage your condition.
    To complement the nailfungus.ca website, we are happy to provide you access to a new booklet about toenail fungus infections. To download a copy of Your Complete Guide to Toenail Fungus Infections, please click here.
    http://toenailfungusinformationprogram.ca/pdf/TIP_Guide.pdf
    If you have indicated that you would like to receive a copy of the guide by mail, please allow four to six weeks for delivery. 
    As a reminder, your family doctor, dermatologist or podiatrist are the medical experts to speak to when it comes to the diagnosis and treatment of toenail fungus infections. Start off on the right foot by consulting your doctor if you suspect you have a toenail fungus infection.
    You may unsubscribe from TIP at any time. To unsubscribe, click here.
    mailto:info@toenailfungusinformationprogram.ca
    ';
    $html = '
    <p>Thank you for visiting nailfungus.ca and for signing up to the Toenail Fungus Information Program (TIP). We look forward to providing you with new and useful information to help you manage your condition.</p>
    <p>To complement the nailfungus.ca website, we are happy to provide you access to a new booklet about toenail fungus infections. To download a copy of <strong>Your Complete Guide to Toenail Fungus Infections,</strong> <a href="http://toenailfungusinformationprogram.ca/pdf/TIP_Guide.pdf">please click here</a>. If you have indicated that you would like to receive a copy of the guide by mail, please allow four to six weeks for delivery.</p>
    <p>As a reminder, your <strong>family doctor</strong>, <strong>dermatologist</strong> or <strong>podiatrist</strong> are the medical experts to speak to when it comes to the diagnosis and treatment of toenail fungus infections. Start off on the right foot by consulting your doctor if you suspect you have a toenail fungus infection.</p>
    <p><em>You may unsubscribe from TIP at any time. To unsubscribe, <a href="mailto:info@toenailfungusinformationprogram.ca">click here</a>.</em></p>
    ';
}
else
{
    $subject = 'Bienvenue au PIMO';
    $text = '
    Merci d\'avoir visité mycosedesongles.quebec et de vous être inscrit au Programme sur la mycose des ongles d\'orteils (PIMO). Nous sommes heureux de pouvoir vous offrir de nouveaux renseignements utiles qui vous aideront à gérer votre condition.
    Nous sommes ravis de vous offrir l\'accès à une nouvelle brochure sur la mycose des ongles d\'orteils, complément au site mycosedesongles.quebec. Cliquez ici pour télécharger votre copie de Votre guide complet sur la mycose des ongles d\'orteils.
    http://toenailfungusinformationprogram.ca/pdf/PIMO_Guide.pdf
    Si vous avez indiqué que vous désirez recevoir celui-ci par la poste, veuillez prévoir 4 à 6 semaines pour la livraison.
    Nous vous rappelons que votre médecin de famille, votre dermatologue et votre podologue sont des experts médicaux. Il est important de discuter avec eux en ce qui concerne les diagnostiques et les traitements pour la mycose des ongles d\'orteils. Partez du bon pied, consultez votre docteur si vous croyez avoir une infection fongique des ongles d\'orteils.
    Vous pouvez vous désabonner du PIMO en tout temps. Pour vous désabonner, cliquez ici.
    mailto:info@toenailfungusinformationprogram.ca
    ';
    $html = '
    <p>Merci d\'avoir visité mycosedesongles.quebec et de vous être inscrit au Programme sur la mycose des ongles d\'orteils (PIMO). Nous sommes heureux de pouvoir vous offrir de nouveaux renseignements utiles qui vous aideront à gérer votre condition.</p>
    <p>Nous sommes ravis de vous offrir l\'accès à une nouvelle brochure sur la mycose des ongles d\'orteils, complément au site mycosedesongles.quebec. <a href="http://toenailfungusinformationprogram.ca/pdf/PIMO_Guide.pdf">Cliquez ici</a> pour télécharger <em>votre copie de Votre guide complet sur la mycose des ongles d\'orteils</em>. Si vous avez indiqué que vous désirez recevoir celui-ci par la poste, veuillez prévoir 4 à 6 semaines pour la livraison.</p>
    <p>Nous vous rappelons que votre médecin de famille, votre dermatologue et votre podologue sont des experts médicaux. Il est important de discuter avec eux en ce qui concerne les diagnostiques et les traitements pour la mycose des ongles d\'orteils. Partez du bon pied, consultez votre docteur si vous croyez avoir une infection fongique des ongles d\'orteils.</p>
    <p><em>Vous pouvez vous désabonner du PIMO en tout temps. Pour vous désabonner, <a href="mailto:info@toenailfungusinformationprogram.ca">cliquez ici</a>.</em></p>
    ';
}
$message
    ->addTo($email)
    ->setFrom('info@toenailfungusinformationprogram.ca')
    ->setSubject($subject)
    ->setText($text)
    ->setHtml($html)
;
try
{
    $sendgrid->send($message);
}
catch(\SendGrid\Exception $e) {}
    
$message = new SendGrid\Email();
$subject = 'TIP Registration - ';
if ($receive_guide)
{
    $subject .= 'Print';
}
else
{
    $subject .= 'Digital Only';
}
$text = "first name: $first_name 
last name: $last_name 
address: $address 
city: $city
province: $province 
postal code: $postal_code 
telephone: $telephone
email: $email 
date of birth: $date_of_birth 
receive info: $receive_info
receive printed guide: $receive_guide
language: $lang";
$message
    ->addTo('info@toenailfungusinformationprogram.ca')
    ->setFrom('info@toenailfungusinformationprogram.ca')
    ->setSubject($subject)
    ->setText($text)
;
try
{
    $sendgrid->send($message);
}
catch(\SendGrid\Exception $e) {}

echo json_encode(array('success'=>1));
?>