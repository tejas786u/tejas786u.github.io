<?php

if(isset($_POST['email'])) {
	
	include 'freecontactformsettings.php';
	
	// Include PHPMailer
	require 'lib/phpmailer/PHPMailer.php';
	require 'lib/phpmailer/SMTP.php';
	require 'lib/phpmailer/Exception.php';
	
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	
	function died($error) {
		echo "died called";
		echo "Sorry, but there were error(s) found with the form you submitted. ";
		echo "These errors appear below.<br /><br />";
		echo $error."<br /><br />";
		echo "Please go back and fix these errors.<br /><br />";
		die();
	}
	
	if(!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['message'])) 
	{
		died('Sorry, there appears to be a problem with your form submission.');		
	}
	
	$full_name = $_POST['name']; // required
	$email_from = $_POST['email']; // required
	$msg_form = $_POST['message']; // required

	$error_message = "";
	
	if (empty($full_name)) {
		$error_message .= 'Name is required.<br />';
	}
	if (empty($email_from) || !filter_var($email_from, FILTER_VALIDATE_EMAIL)) {
		$error_message .= 'A valid email is required.<br />';
	}
	if (empty($msg_form)) {
		$error_message .= 'Message is required.<br />';
	}
  
  if(strlen($error_message) > 0) {
  	died($error_message);
  }
	
	// Create a new PHPMailer instance
	$mail = new PHPMailer(true);
	
	try {
		// Server settings
		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPAuth = true;
		$mail->Username = 'tejas786u@gmail.com'; // Your Gmail address
		$mail->Password = 'YOUR_GMAIL_APP_PASSWORD'; // Your Gmail app password (not regular password)
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
		$mail->Port = 587;
		
		// Recipients
		$mail->setFrom('tejas786u@gmail.com', 'Tejas Website');
		$mail->addAddress($email_to); // Add recipient
		
		// Content
		$mail->isHTML(false);
		$mail->Subject = $email_subject;
		$mail->Body = "Form details below.\r\n\r\n" .
					  "Full Name: " . clean_string($full_name) . "\r\n" .
					  "Email: " . clean_string($email_from) . "\r\n" .
					  "Message: " . clean_string($msg_form) . "\r\n";
		
		$mail->send();
		header('Location: index.php?sent=1');
	} catch (Exception $e) {
		header('Location: index.php?error=1');
	}
}
die();

function clean_string($string) {
  $bad = array("content-type","bcc:","to:","cc:");
  return str_replace($bad,"",$string);
}
?>