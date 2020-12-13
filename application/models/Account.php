<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	public function getAccount($username)
	{
		$this->db->where('username', $username);
		return $this->db->get('accounts')->row_array();
	}

	public function getAccountByCreateBy($username)
	{
		$this->db->where('createBy', $username);
		return $this->db->get('accounts')->result_array();
	}

	public function getAllAccount()
	{
		return $this->db->get('accounts')->result_array();
	}

	public function updateAccount($username, $data)
	{
		$this->db->where('username', $username);
		return $this->db->update('accounts', $data);
	}

	public function createAccount($data)
	{
		$this->db->insert('accounts', $data);
		return $this->db->insert_id();
	}
}

/* End of file Account.php */
/* Location: ./application/models/Account.php */