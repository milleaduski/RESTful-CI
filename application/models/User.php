<?php

class User extends CI_Model
{
	public function save(){
		$data	= [
			'email'		=> $this->input->post('email'),
			'password'	=> password_hash($this->input->post('password'), PASSWORD_DEFAULT),
		];
		$result = $this->db->insert('users',$data);
		if($result){
			return [
				'id'		=> $this->db->insert_id(),
				'status' 	=> true,
				'message'	=> 'Data successfully added'
			];
		}
	}
}