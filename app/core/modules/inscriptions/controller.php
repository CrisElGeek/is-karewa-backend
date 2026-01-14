<?php
use App\Helpers\ApiResponse;
use App\Helpers\ApiMailer;

class InscriptionsMailer {
	public function store() {
		global $_payload;
		global $_apiConfig;
		$mailingAddresses = json_decode($_apiConfig->mailing_addresses);
		$inscriptions = $mailingAddresses->inscriptions;
		$system = $mailingAddresses->system;
		$html = $this->createHtml($_payload);
		$birth_doc = json_decode($_payload->birth_doc);
		$id_doc = json_decode($_payload->id_doc);
		$curp_doc = json_decode($_payload->curp_doc);
		$cert_doc = json_decode($_payload->cert_doc);
		$statics_path = ROOT_DIR . STATIC_PATH;
		$params = [
			'from' => ['email' => $system->email, $system->name],
			'to' => [
				['email' => $inscriptions->email, 'name' => $inscriptions->name]
			],
			'reply_to' => ['email' => $_payload->email, 'name' => $_payload->name . ' ' . $_payload->last_name1],
			'subject' => "Nueva solicitud de inscripción desde el sitio web caep.org.mx",
			'html_body' => $html,
			'text_body' => 'Nueva solicitud de inscripción desde el sitio web caep.org.mx',
			'attachments' => [
				['file' => $statics_path . $birth_doc->image, 'name' => $birth_doc->name],
				['file' => $statics_path . $id_doc->image, 'name' => $id_doc->name],
				['file' => $statics_path . $curp_doc->image, 'name' => $curp_doc->name],
				['file' => $statics_path . $cert_doc->image, 'name' => $cert_doc->name]
			]
		];
		try {
			ApiMailer::Send($params);
		} catch(\AppException $e) {
			ApiResponse::Set($e->errorCode());
		}
		ApiResponse::Set('SUCCESS');
	}

	private function createHtml($payload) {
		$dob = $payload->dob;
		return
<<<HTML
	<p><strong>Nombre:</strong> $payload->name</p>
	<p><strong>Apellido paterno:</strong> $payload->last_name1</p>
	<p><strong>Apellido materno:</strong> $payload->last_name2</p>
	<p><strong>Correo electrónico:</strong> $payload->email</p>
	<p><strong>Courso o diplomado:</strong> $payload->course</p>
	<p><strong>Lugar de nacimiento:</strong> $payload->birth_location</p>
	<p><strong>Fecha de nacimiento:</strong> $dob</p>
	<p><strong>Lugar de residencia:</strong> $payload->location</p>
	<p><strong>Nacionalidad:</strong> $payload->nationality</p>
	<p><strong>Último grado de estudios:</strong> $payload->degree</p>
	<p><strong>Otro curso que le gustaría que impartieramos:</strong> $payload->opinion</p>
	<p><strong>Medio por el que se entero de CAEP:</strong> $payload->media</p>
HTML;
	}
}
?>
