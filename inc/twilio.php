<?php

require_once trailingslashit(WP_CONTENT_DIR) . 'themes/norcanna/Twilio/autoload.php';
use Twilio\Rest\Client;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Exceptions\RestException;


class Twilio_Integration {

	private $client;
	public $user_id;
	public $data_arr;
	public $is_success;



	public function __construct( $user_id = false, $data = array() ) {
		$this->setDefaultVal( $user_id, $data );
	}

	private function setCredenTials(){
		$sid = 'AC4b7c5f54bb32f33d596d3de413256e7e';
		$token = '955f006784a44e2809269a7003398caf';
		$this->client = new Client($sid, $token);
	}

	private function setDefaultVal( $user_id, $data ) {
		$this->is_success = false;
		$this->user_id    = $user_id;
		$this->data_arr   = $data;
		if($this->data_arr['from']){
			$this->data_arr['from'] = '+17076837132';
		}
		$this->setCredenTials();
	}

	public function sendMessage(){
		if(empty($this->data_arr['body'])){
			$this->is_success = false;
			return false;
		}
		$data = [];
		$data['body'] = $this->data_arr['body'];
		if(!empty($this->data_arr['from'])) {
			$data['from'] = $this->data_arr['from'];
		}
		try {
			$this->is_success = $this->client->messages->create(
				$this->data_arr['to'],
				$data
			);

		} catch (TwilioException $e){
			error_log('Status Code: ' . $e->getCode() . ', ' . $e->getMessage());
		}
		return $this->is_success;
	}


}