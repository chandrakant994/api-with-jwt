<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('AuthModel');
	}

	public function login()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$jwt = new JWT();
		$jwtSecretKey = 'Asselfishasshilpa';

		$result = $this->AuthModel->check_login($email,$password);
		if(!empty($result)){

			$jwt = new JWT();
			$jwtSecretKey = 'Asselfishasshilpa';
			$token  = $jwt->encode($result,$jwtSecretKey,'HS256');
			
			$msg = 'Login Successful';
			$status = 1;
		}else{
			$token = 'Check login details';
			$msg = 'Login Failed';
			$status = 0;

		}
		
		$arr = array(
			'status'=>$status,
			'message'=>$msg,
			'token'=>$token
		);

		echo json_encode($arr);
	}


	public function signup(){
		if($this->input->post()){
			$email = $this->input->post('email');
			$name = $this->input->post('name');
			$password = $this->input->post('password');
			$data = array(
				'email'=>$email,
				'name'=>$name,
				'password'=>$password,
				'status'=>1
			);
			$result = $this->AuthModel->signup($data);

			if($result){

				$jwt = new JWT();
				$jwtSecretKey = 'Asselfishasshilpa';

				$data['user_id'] = $result;

				$token  = $jwt->encode($data,$jwtSecretKey,'HS256');
				$data['token'] = $token;

				$msg = 'Register Successful';
				$status = 1;
			}else{
				$data = '';
				$msg = 'Something went wrong';
				$status = 0;
			}

			$arr = array(
				'status'=>$status,
				'msg'=>$msg,
				'detail'=>$data
			);

		}else{
			$arr = array(
				'status'=>0,
				'msg'=>'Please fill required field',
				'detail'=>''
			);
		}
		echo json_encode($arr);
	}


	public function getToken(){
		$jwt = new JWT();
		$jwtSecretKey = 'Asselfishasshilpa';
		$data = array(
			'name'=>'Chandrakant',
			'email'=>'chktkr1994@gmail.com',
			'password'=>'1234456'
		);
		$token  = $jwt->encode($data,$jwtSecretKey,'HS256');
		echo $token;
	}

	public function decode_token(){
		$token  = $this->uri->segment(3);
		$jwt = new JWT();

		$jwtSecretKey = 'Asselfishasshilpa';

		$data = $jwt->decode($token,$jwtSecretKey,'HS256');
		//echo $data;

		$jsondata = $jwt->jsonEncode($data);
		print_r($jsondata);
	}
}
