<?php 

class AuthModel extends CI_Model{

	public function check_login($email,$password){
		

		$this->db->where('email',$email);
		$this->db->where('password',$password);
		$this->db->where('status',1);

		$res = $this->db->get('user')->row();

		if(!empty($res)){
			return $res;
		}else{
			return '';
		}

	}

	public function signup($data){

		$this->db->insert('user',$data);
		$insertid = $this->db->insert_id();
		return $insertid;

	}
}
