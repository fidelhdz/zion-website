<?php
	$data = json_decode(file_get_contents('php://input'), true);
	ini_set("include_path", ''); // Donde esten las librerias de PHP

	// DESCARGAR PHPMailer DESDE EL REPOSITORIO: https://github.com/PHPMailer/PHPMailer
	/*
		ELIMINAR LA SIGUIENTE INFORMACION

		Formato para crear define_vars.php
		define("MAIL_SMTPSERVER", "smtp.tuserver.com");
		define("MAIL_SMTPPORT", 999); <-- PUERTO DE SALIDA
		define("MAIL_USERNAME", "usarioroot");
		define("MAIL_PASSWORD", "password");
		define("MAIL_PRINCIPAL", "correo@principal.com");
		define("MAIL_SECONDARY", "correo@secundario.com");
	*/

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	require ini_get("include_path") . '/PHPMailer/src/Exception.php';
	require ini_get("include_path") . '/PHPMailer/src/PHPMailer.php';
	require ini_get("include_path") . '/PHPMailer/src/SMTP.php';
	require_once(ini_get("include_path") . '/define_vars.php'); // Recomiendo usar las variables en el mismo lugar donde esten las librerias de PHP

	$mail = new PHPMailer(true);

	$form_Solution  = $data['solution'];
	$form_Market    = $data['market'];
	$form_Name      = $data['fname'] . ' ' . $data['lname'];
	$form_Title     = $data['title'];
	$form_Company   = $data['company'];
	$form_Email     = $data['email'];
	$form_Phone     = $data['phone'];
	$form_State     = $data['state'];
	$form_Country   = $data['country'];
	$form_Message   = $data['message'];

	$body = "---------- <br>\r\n\n";
	$body .= 'Nombre: ' . $form_Name . "<br>\r\n\n";
	$body .= 'Título: ' . $form_Title . "<br>\r\n\n";
	$body .= 'Compañía: ' . $form_Company . "<br>\r\n\n";
	$body .= 'Correo: ' . $form_Email . "<br>\r\n";
	$body .= 'Teléfono: ' . $form_Phone . "<br>\r\n";
	$body .= 'Tipo de solución: ' . $form_Solution . "<br>\r\n\n";
	$body .= 'Nicho de mercado: ' . $form_Market . "<br>\r\n\n";
	$body .= 'Estado: ' . $form_State . "<br>\r\n";
	$body .= 'País: ' . $form_Country . "<br>\r\n";
	$body .= 'Mensaje: ' . "\r\n" . $form_Message . "<br>\r\n";
	$body .= "---------- <br>\r\n\n";


	$body_alt = "---------- \r\n\n";
	$body_alt .= 'Nombre: ' . $form_Name . "\r\n\n";
	$body_alt .= 'Título: ' . $form_Title . "\r\n\n";
	$body_alt .= 'Compañía: ' . $form_Company . "\r\n\n";
	$body_alt .= 'Correo: ' . $form_Email . "\r\n";
	$body_alt .= 'Teléfono: ' . $form_Phone . "\r\n";
	$body_alt .= 'Tipo de solución: ' . $form_Solution . "\r\n\n";
	$body_alt .= 'Nicho de mercado: ' . $form_Market . "\r\n\n";
	$body_alt .= 'Estado: ' . $form_State . "\r\n";
	$body_alt .= 'País: ' . $form_Country . "\r\n";
	$body_alt .= 'Mensaje: ' . "\r\n" . $form_Message . "\r\n";
	$body_alt .= "---------- \r\n\n";

	try {
		//Server settings
		$mail->CharSet    = "UTF-8";
		$mail->Encoding   = 'base64';
		$mail->SMTPDebug  = SMTP::DEBUG_SERVER;                //Enable verbose debug output
		$mail->isSMTP();                                       //Send using SMTP
		$mail->Host       = MAIL_SMTPSERVER;	               //Set the SMTP server to send through
		$mail->SMTPAuth   = true;                              //Enable SMTP authentication
		$mail->Username   = MAIL_USERNAME;	                   //SMTP username
		$mail->Password   = MAIL_PASSWORD;                     //SMTP password
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;       //Enable implicit TLS encryption
		$mail->Port       = MAIL_SMTPPORT;                     //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		//Recipients
		$mail->setFrom($form_Email);
		$mail->addAddress(MAIL_PRINCIPAL, 'Zion Automation');  //Add a recipient
		$mail->addReplyTo(MAIL_PRINCIPAL, 'Información');
		$mail->addBCC(MAIL_SECONDARY, 'IT Department');

		//Content
		$mail->isHTML(true);                                   //Set email format to HTML
		$mail->Subject = 'Mensaje para Zion Automation';
		$mail->Body    = $body;
		$mail->AltBody = $body_alt;

		$mail->send();
		echo 'Mensaje enviado exitosamente.';
	} catch (Exception $e) {
		echo "No se pudo enviar el mensaje.";
	}
?>