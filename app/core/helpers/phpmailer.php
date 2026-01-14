<?php
namespace App\Helpers;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

abstract class ApiMailer {
	static public function Send(Array $params) {
		global $_apiConfig;
		$smtpAuth = json_decode($_apiConfig->smtp_auth);
		$mail = new PHPMailer(true);
		try {
			//Server settings
			$mail->SMTPDebug = $smtpAuth->debug;
			$mail->isSMTP();
			$mail->Host       = $smtpAuth->host;
			$mail->SMTPAuth   = $smtpAuth->smtp_auth;
			$mail->Username   = $smtpAuth->user;
			$mail->Password   = $smtpAuth->pass;
			$mail->SMTPSecure = $smtpAuth->security;
			$mail->Port       = $smtpAuth->port;
			//$mail->CharSet 		= $SMTPAuth->charset;
			//Recipients
			$mail->setFrom($params['from']['email'], $params['from']['name']);
			foreach($params['to'] as $recipient) {
				$mail->addAddress($recipient['email'], $recipient['name']);
			}
			if(isset($params['reply_to'])) {
				$mail->addReplyTo($params['reply_to']['email'], $params['reply_to']['name']);
			}
			foreach($params['cc'] as $recipient) {
				$mail->addCC($recipient['email']);
			}
			foreach($params['bcc'] as $recipient) {
				$mail->addBCC($recipient['email']);
			}

			//Attachments
			foreach($params['attachments'] as $attachment) {
				$mail->addAttachment($attachment['file'], $attachment['name']);
			}

			//Content
			$mail->isHTML(true);
			$mail->Subject = utf8_decode($params['subject']);
			$mail->Body    = utf8_decode($params['html_body']);
			$mail->AltBody = utf8_decode($params['text_body']);

			$mail->send();
		} catch (Exception $e) {
			$params_string = json_encode($params);
			throw new \AppException("Message could not be sent. Mailer Error: {$mail->ErrorInfo} {$params_string}", 903000);
		}
	}
}
?>
