<?php

class User extends CI_Model
{
	public function save() {
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

	public function get_all($id = null){
		if($id != null) {
			$query  = $this->db->get_where('users', array('id' => $id));
			return $query->result();
		}
		$query  = $this->db->get('users');
		return $query->result();
	}
}