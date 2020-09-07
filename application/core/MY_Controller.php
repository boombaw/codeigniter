<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Response output browser
	 * @param  string $code    [header code]
	 * @param  string $message [message response]
	 * @return [Object]        [Json]
	 */
	function responseJson($code='', $message = "")
	{
		return $this->output
		            ->set_content_type('application/json')
		            ->set_status_header($code)
		            ->set_output(json_encode($message));
		exit();
	}

}

/* End of file MY_Controller.php */
/* Location: ./application/controllers/MY_Controller.php */