<?php
use App\Libs\Mailer;

class recoveryMailer
{
  function __construct(int $code, string $email, $name)
  {
    $this->code   = $code;
    $this->email  = $email;
    $this->name   = $name;
  }

  public function init()
  {
    $bodyMsg =
<<<HTML
<!DOCTYPE html>
  <html>
    <head>
      <meta charset="utf-8">
      <title>Mailer Template</title>
      <meta name="viewport" content="width=768, initial-scale=1">
      <style media="screen" type="text/css">
      @import url('https://fonts.googleapis.com/css2?family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&display=swap');
        *{
          box-sizing: border-box;
        }
        html, body{
          font-family: 'PT Serif', Serif;
          padding: 0;
          margin: 0;
          font-size:16px;
          background-color: #f9f9f9;
        }
        .mailer__container{
          background-color: #FFF;
          border-radius: 4px;
          width: 100%;
          max-width: 768px;
          margin: auto;
          padding: 2%;
          border: 1px solid #f3f3f3;
          margin-top: 50px;
        }
        .mailer__title,
        .mailer__subtitle{
          padding:0;
          margin: 0;
          text-align: center
        }
        .mailer__title{
          font-size: 2rem;
          font-weight: 300;
        }
        .mailer__subtitle{
          font-size: 1.2rem;
          font-weight: 400;
        }
        .mailer__text{
          line-height1.5rem;
          margin-top: 40px;
          font-weight: 300;
        }
        .mailer__text--strong{
          font-weight: 700;
        }
        .mailer__list{
          margin-top: 30px;
        }
        .mailer__element{
          list-style: disc;
          margin: 5px auto;
        }
        .mailer__element--strong{
          font-weight: 700;
        }
      </style>
    </head>
    <body>
      <div class="mailer">
        <div class="mailer__container">
          <h1 class="mailer__title">Knox The Shop</h1>
          <h2 class="mailer__subtitle">Solicitud de cambio de contraseña</h2>
          <p class="mailer__text">¡Atención! No comparta este código con nadie:</p>
          <ul class="mailer__list">
            <li class="mailer__element"><strong class="mailer__element--strong">Código: </strong> $this->code </li>
          </ul>
          <p class="mailer__text">Regresa a nuestro sitio web y utiliza este código para recuperar el acceso a tu cuenta o bien para cambiar tu contraseña, este código expira en una hora a partir del momento en que se generó.</p>
          <p class="mailer__text">Si tu no realizaste esta solicitud, haga caso omiso.</p>
        </div>
      </div>
    </body>
  </html>
HTML;
    $mailer_data = [
      "to"    => [
        [$this->email, $this->name]
      ],
      "subject" => "Solicitud de recuperación de contraseña de acceso",
      "body"    => $bodyMsg,
      "alt"     => "¡Atención! No comparta este código con nadie: " .$this->code .". Utilízalo para recuperar el acceso a tu cuenta o bien para cambiar tu contraseña, este código expira en una hora a partir del momento en que se generó."
    ];
    return Mailer::send($mailer_data);
  }
}
?>
