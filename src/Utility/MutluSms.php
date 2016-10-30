<?php  
namespace MutluSms\Utility;

use Cake\ORM\TableRegistry;
/**
* 
*/
class MutluSms
{
	private $_config;
	
	/**
	 * array config
	 * Example:
	 * $config[
	 * 	'ka' => 'username',
	 * 	'pwd' => 'password',
	 * 	'org' => 'organisationName'
	 * ]
	 */
	function __construct(array $config)
	{
		$this->_config = $config;
	}

	public function create(array $data)
	{
		$MutluMessages = TableRegistry::get('MutluSms.MutluMessages');
		$mutluMessage = $MutluMessages->newEntity();
		$MutluMessages->patchEntity($mutluMessage, $data);

		if($MutluMessages->save($mutluMessage)) {
			return $mutluMessage->id;
		} else {
			return false;
		}
	}

	public function send($messageId='')
	{
		$MutluMessages = TableRegistry::get('MutluSms.MutluMessages');
		$mutluMessage = $MutluMessages->get($messageId);

		$message = $this->createMessage($mutluMessage);
		$xml_data = $this->createXml([$message]);
		$this->apiCall($xml_data);

		$mutluMessage->sent = true;
		$MutluMessages->save($mutluMessage);

	}

	public function sendAll()
	{
		$MutluMessages = TableRegistry::get('MutluSms.MutluMessages');
		$mutluMessages = $MutluMessages->find('all')->where(['sent' => false]);

		$messagesToSend = array();
		foreach ($mutluMessages as $mutluMessage) {
			$messagesToSend[] = $this->createMessage($mutluMessage);
		}
		$xml_data = $this->createXml($messagesToSend);
		$this->apiCall($xml_data);

		$MutluMessages->setSentAll();

	}


	private function createMessage($mutluMessage)
	{
		$message = '';
		$message .= '<mesaj>'.
		$message .=        '<metin>'.$mutluMessage->message.'</metin>';
		$message .=         '<nums>'.$mutluMessage->number.'</nums>';
		$message .= '</mesaj>';
		return $message;
	}

	private function createXml(array $messages) 
	{
		$xml_data ='<?xml version="1.0" encoding="UTF-8"?>'.
		'<smspack ka="'.$this->_config['ka'].'" pwd="'.$this->_config['pwd'].'" org="'.$this->_config['org'].'" >';
		foreach ($messages as $message) {
			$xml_data .= $message;
		}
		$xml_data .='</smspack>';
	}

	private function apiCall($xml_data)
	{
		$URL = "https://smsgw.mutlucell.com/smsgw-ws/sndblkex";
 
		$ch = curl_init($URL);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		curl_close($ch);
	}
}