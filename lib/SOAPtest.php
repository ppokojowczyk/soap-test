<?php

class SOAPtest {

	private $url = '',
	        $response = '',
	        $request = '';

	public static function run(){
		$SOAPtest = new self;
        $SOAPtest->setup();
		$SOAPtest->send();
		$SOAPtest->returnData();
        exit();
    }

	function __construct(){}

    /*
     * Try to pretty-print response
     */
    private function formatContent($content){
        $tmp = $content;

        // use tidy if possible
        if(function_exists('tidy_repair_string'))
            $tmp = tidy_repair_string($content, ['input-xml'=> 1, 'indent' => 1, 'wrap' => 0]);

        //$tmp = preg_replace('/(?:^|\G)  /um', "\t", $tmp);
        return $tmp;
    }

	private function send(){
		try {
			$ch = curl_init($this->url);
			$headers = array(
				'content-type: text/xml; charset=UTF-8',
				'soapaction: "ubtraco.localhost/agriwebserwis#DostawcaPobierz"'
			);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $this->request);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$this->response = $this->formatContent(curl_exec($ch));

			if(FALSE === $this->response)
				throw new Exception(curl_error($ch), curl_errno($ch));

		} catch(Exception $e){
			$this->response = $e->getMessage();
		}
		curl_close($ch);
	}

	private function setup(){
		//$this->url = 'https://smithfieldtest.nova-tms.com/ws/agriws.php';
		//$this->url = 'https://ubtraco.localhost/ws/agriws.php';

        if(isset($_POST['url']))
            $this->url = $_POST['url'];

		if(isset($_POST['request']))
			$this->request = $_POST['request'];
	}

	private function returnData(){
		$data = array(
			'response' => $this->response,
			'request' => $this->request
		);
		echo json_encode($data);
	}

}

$send = isset($_GET['send']) ? true : false;

if($send)
	SOAPtest::run();
