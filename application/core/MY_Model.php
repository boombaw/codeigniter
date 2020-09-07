<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {

	/*
	 * --------------------------------------------------------------
     * VARIABLES
     * --------------------------------------------------------------
     * 
    */

    /**
     * This model's default database table. Automatically
     * guessed by pluralising the model name.
     */
    protected $_table;

    /**
     * This model's default primary key or unique identifier.
     * Used by the get(), update() and delete() functions.
     */
    protected $primaryKey = 'id';


	/* --------------------------------------------------------------
	 * GENERIC METHODS
	 * ------------------------------------------------------------ */

    /**
     * Initialise the model, tie into the CodeIgniter superobject and
     * try our best to guess the table name.
     */
    public function __construct()
	{
		$this->load->helper('inflector');
		parent::__construct();		
		
		$this->_fetch_table();
	}

	/**
	 * Find Data
	 * 
	 * @param  string tableName but is optional
	 * @param  string or array $value 
	 * @return object
	 */
	public function find($value='')
	{
		if (func_num_args() == 2) {
			$this->_table = func_get_arg(0);
		}

		if (is_array($value)) {
			$condition = $value;
		}else{
			$condition = [ $this->primaryKey => $value ];
		}

		return $this->db->get_where($this->_table, $condition);
	}

	public function findAll()
	{
		if (func_num_args() > 0) {
			$this->_table = func_get_arg(0);
		}
		return $this->db->get($this->_table);
	}

	public function insert($data=[])
	{
		if (func_num_args() > 1) {
			$this->_table = func_get_arg(0);
			$data         = func_get_arg(1);
		}

		$this->db->insert($this->_table, $data);
		$id = $this->db->insert_id();
		return $id;
	}

	public function update($data=[], $condition = [])
	{
		if (func_num_args() > 2) {
			$this->_table = func_get_arg(0);

			$data      = func_get_arg(1);
			$condition = func_get_arg(2);
		}

		return $this->db->update($this->_table, $data, $condition);
	}

	public function delete($condition= [])
	{
		if (func_num_args() > 1) {
			$this->_table = func_get_arg(0);
			$condition    = func_get_arg(1);
		}

		return $this->db->delete($this->_table, $condition);
	}

	public function exist($primaryKey='')
	{
		if (func_num_args() > 1) {
			$this->_table = func_get_arg(0);
			$primaryKey   = func_get_arg(1);
		}

		if (is_array($primaryKey)) {
			$arr_criteria = $primaryKey;
		}else{
			$arr_criteria = [ $this->primaryKey => $primaryKey ];
		}

		$count = $this->db->get_where($this->_table, $arr_criteria)->num_rows();

		if ($count > 0) {
			return true;
		}else{
			return false;
		}
	}

	public function select($fields='', $condition = '', $limit = 0)
	{
		if (func_num_args() > 3) {
			$this->_table = func_get_arg(0);

			$fields    = func_get_arg(1);
			$condition = func_get_arg(2);
			$limit     = func_get_arg(3);
		}

		if (is_array($fields)) {
			for ($i=0; $i < count($fields); $i++) { 
				$this->db->select($fields[$i], FALSE);
			}
		}else{
			$this->db->select($fields, FALSE);
		}

		$this->db->from($this->_table);

		if (!empty($condition)) {
			$this->db->where($condition, FALSE);
		}

		if ($limit > 0) {
			$this->db->limit($limit);
		}

		return $this->db->get();
	}


	/**
     * Guess the table name by pluralising the model name
     */
    private function _fetch_table()
    {
        if ($this->_table == NULL)
        {
            $this->_table = plural(preg_replace('/(_m|_model)?$/', '', strtolower(get_class($this))));
        }
    }

    /**
     * Guess the primary key for current table
     */
    private function _fetch_primary_key()
    {
        if($this->primaryKey == NULl)
        {
            $this->primaryKey = $this->db->query("SHOW KEYS FROM `".$this->_table."` WHERE Key_name = 'PRIMARY'")->row()->Column_name;
        }
    }

}

/* End of file MY_Model.php */
/* Location: ./application/models/MY_Model.php */