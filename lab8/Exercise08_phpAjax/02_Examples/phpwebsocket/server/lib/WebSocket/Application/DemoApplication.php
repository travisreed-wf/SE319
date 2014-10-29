<?php

namespace WebSocket\Application;

/**
 * Websocket-Server demo and test application.
 * 
 * @author Simon Samtleben <web@lemmingzshadow.net>
 */
class DemoApplication extends Application
{
    private $_clients = array();
	private $_filename = '';

	public function onConnect($client)
    {
		$id = $client->getClientId();
        $this->_clients[$id] = $client;		
    }

    public function onDisconnect($client)
    {
        $id = $client->getClientId();		
		unset($this->_clients[$id]);     
    }

    public function onData($data, $client)
    {		
        $decodedData = $this->_decodeData($data);		
		if($decodedData === false)
		{
			// @todo: invalid request trigger error...
		}
		
		$actionName = '_action' . ucfirst($decodedData['action']);		
		if(method_exists($this, $actionName))
		{			
			call_user_func(array($this, $actionName), $decodedData['data']);
		}
    }
	
	public function onBinaryData($data, $client)
	{		
		$filePath = substr(__FILE__, 0, strpos(__FILE__, 'server')) . 'tmp/';
		$putfileResult = false;
		if(!empty($this->_filename))
		{
			$putfileResult = file_put_contents($filePath.$this->_filename, $data);			
		}		
		if($putfileResult !== false)
		{
			
			$msg = 'File received. Saved: ' . $this->_filename;
		}
		else
		{
			$msg = 'Error receiving file.';
		}
		$client->send($this->_encodeData('echo', $msg));
		$this->_filename = '';
	}
	
	private function _actionEcho($text)
	{		
		$encodedData = $this->_encodeData('echo', $text);		
		foreach($this->_clients as $sendto)
		{
			$sendto->send($encodedData);
        }
	}

	private function _actionBoldEcho($text)
	{		
		$encodedData = $this->_encodeData('boldEcho', 
      "<font color=\"red\"><b>".$text."</b></font>");		
		foreach($this->_clients as $sendto)
		{
			$sendto->send($encodedData);
        }
	}
	private function _actionSendRandom($text)
	{		
    for ( $i = 0; $i < 10; $i++) {
      sleep($i);
		  $encodedData = $this->_encodeData('sendRandom',
        "<font color=\"blue\"><b>".$text.$i."</b></font>");		

		  foreach($this->_clients as $sendto) {
			  $sendto->send($encodedData);
      }
    }
	}

	
	private function _actionSetFilename($filename)
	{		
		if(strpos($filename, '\\') !== false)
		{
			$filename = substr($filename, strrpos($filename, '\\')+1);
		}
		elseif(strpos($filename, '/') !== false)
		{
			$filename = substr($filename, strrpos($filename, '/')+1);
		}		
		if(!empty($filename)) 
		{
			$this->_filename = $filename;
			return true;
		}
		return false;
	}
}
