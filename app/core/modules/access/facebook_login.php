<?php
require __DIR__ . '/../users/controller.php';
require __DIR__ . '/../customers/controller.php';
use App\Auth\sessionSet;
use App\Model\DBGet;
use Facebook\Exceptions\FacebookSDKException as FBException;
use Facebook\Facebook;

class facebook_login {
  private $request;
  private $fb;

  function __construct($request) {
    $this->request          = $request;
    $this->available_fields = [];
    /**
     * Facebook SDK Graph config
     */
    $this->fb = new Facebook([
      'app_id'                => FB_API_ID,
      'app_secret'            => FB_API_SECRET,
      'default_graph_version' => FB_API_VERSION,
    ]);
  }

  public function login() {
    try
    {
      $response = $this->fb->get(
        $this->request->userID . '?fields=name,email,first_name,last_name,gender,middle_name,locale,verified,link,timezone',
        $this->request->accessToken
      );
    } catch (FBException $e) {
      error_logs([MODULE, 500, json_encode($e->getMessage())], ERROR_LOG_FILE);
      die(json_encode([
        'message' => 'Error login to Facebook',
      ]));
    } catch (FBException $e) {
      error_logs([MODULE, 500, json_encode($e->getMessage())], ERROR_LOG_FILE);
      die(json_encode([
        'message' => 'Error login to Facebook',
      ]));
    }
    $user_data = $response->getGraphNode();
    $params    = [
      'table'   => 'users',
      'fields'  => ['id', 'role_id'],
      'filters' => [
        ['facebook_id', $user_data['id'], '='],
      ],
    ];
    $exist = DBGet::get('', $params);
    // CREA UNA CONTRASENA TEMPORAL PARA EL USUARIO POR SEGURIDAD
    $password = random_string(30);

    if ($user_data['verified'] == 1) {
      $email_status = 1;
    } else {
      $email_status = 2;
    }

    $request                   = new stdClass();
    $request->email            = $user_data['email'];
    $request->first_name       = $user_data['first_name'];
    $request->last_name        = $user_data['last_name'];
    $request->facebook_id      = $user_data['id'];
    $request->role_id          = 5;
    $request->email_verified   = $email_status;
    $request->password         = $password;
    $request->confirm_password = $password;
    if (!$exist) {
      $users = new Users($request);
      $user  = $users->store();
      if (isset($user['errors'])) {
        if (isset($user['errors']['email']['unique'])) {
          http_response_code(409);
          return $user;
        } else {
          http_response_code(406);
          return $user;
        }
      } else {
        return $user;
      }
    } else {
      $customers = new Customers($request);
      $customers->update($exist['id']);

      $login_data = [
        'id'         => $exist['id'],
        'first_name' => $user_data['first_name'],
        'last_name'  => $user_data['last_name'],
        'email'      => $user_data['email'],
        'role_id'    => $exist['role_id'],
      ];
      return sessionSet::login($login_data);
    }
  }
}
?>
