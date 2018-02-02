<?php

if(isset($_POST['email'])) {
	
	include 'freecontactformsettings.php';
	
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
  
  if(strlen($error_message) > 0) {
  	died($error_message);
  }
	$email_message = "Form details below.\r\n";
	
	function clean_string($string) {
	  $bad = array("content-type","bcc:","to:","cc:");
	  return str_replace($bad,"",$string);
	}
	
	$email_message .= "Full Name: ".clean_string($full_name)."\r\n";
	$email_message .= "Email: ".clean_string($email_from)."\r\n";
	$email_message .= "Message: ".clean_string($msg_form)."\r\n";
	
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
//mail($email_to, $email_subject, $email_message);
mail($email_to, $email_subject, $email_message, $headers);
//header("Location: index.html");
header('Location: index.html');
?>
 <!-- <script>location.replace('<?php echo $thankyou;?>')</script> -->
<?php
}
die();
?>