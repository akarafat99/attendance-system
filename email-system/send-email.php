<?php
// session
if (session_status() == PHP_SESSION_NONE) {
	// Only start the session if it's not already started
	session_start();
}

include("smtp/PHPMailerAutoload.php");
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'TLS';
$mail->Host = "smtp.gmail.com";
$mail->Port = 587;
$mail->IsHTML(true);
$mail->CharSet = 'UTF-8';
$mail->Username = "hr3989012@gmail.com";
$mail->Password = "pudpqyedchxjnipn";
$mail->SetFrom("hr3989012@gmail.com");

function sendMail($to, $subject, $msg)
{
	global $mail;

	$mail->Subject = $subject;
	$mail->Body = $msg;
	$mail->ClearAddresses();
	$mail->AddAddress($to);

	$mail->SMTPOptions = array(
		'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => false
		)
	);

	if (!$mail->Send()) {
		// echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		// echo "Message sent successfully";
	}
}


sendMail("arafatabdulkhaled@gmail.com", "Test 2", "Hello World!");

?>

<!--  -->