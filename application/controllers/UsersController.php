<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH .'libraries/JWT.php';

use  \Firebase\JWT\JWT;
use \Firebase\JWT\SignatureInvalidException;
class UsersController extends CI_Controller {

	private $secret = "This is a secret key";
	public function __construct() {
		parent::__construct();
		$this->load->model('user');
	}

	public function response($data) {
		$this->output
			 ->set_content_type('application/json')
			 ->set_status_header(200)
			 ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
			 ->_display();
		exit;
	}

	public function register() {
		return $this->response($this->user->save());
	}

	public function all_users() {
		return $this->response($this->user->get_all());
	}

	public function detail_user($id) {
		return $this->response($this->user->get_all($id));
	}

	public function login() {
		if (!$this->user->is_valid()) {
			return $this->response([
				'success'	=> false,
				'message'	=> 'Password or Email is wrong'
			]);
		}

		//Get User data
		$email = $this->input->post('email');
		$user = $this->user->get_all('email',$email);

		// Collect data
		$date = new DateTime();
		$payload['id'] 		= $user[0]->id;
		$payload['email'] 	= $user[0]->email;
		$payload['iat'] 	= $date->getTimestamp();
		$payload['exp'] 	= $date->getTimestamp() + 60*60*2;

		$output['id_token'] = JWT::encode($payload, $this->secret);
		$this->response($output);
	}

	public function check_token() {
		$jwt = $this->input->get_request_header('Authorization');

		try {
			//decode token with HS256 method
			$decode = JWT::decode($jwt, $this->secret, array('HS256'));
			var_dump($decode);exit;
		} catch(\Exception $e) {
			return $this->response([
				'success'	=> false,
				'message'	=> 'invalid token'
			]);
		}
	}
}