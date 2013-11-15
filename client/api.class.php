<?php

class SMS {

	static public $API_URL='http://localhost:85/simpleAPI/v3/server/api.init.php';
	static public $API_KEY='a74f7419b27c9b5b982d4931915f8ce5'; //kodok md5 hashes

	private static function send_data_post($data, $referer=''){
		// Convert the data array into URL Parameters like a=b&foo=bar etc.
		$url=self::$API_URL;
		$data['api_key']=self::$API_KEY;
	    $data = http_build_query($data);
	 
	    // parse the given URL
	    $url = parse_url($url);
	 
	    if ($url['scheme'] != 'http') { 
	        die('Error: Only HTTP request are supported !');
	    }
	 
	    // extract host and path:
	    $host = $url['host'];
	    $path = $url['path'];
	 
	    // open a socket connection on port 80 - timeout: 30 sec
	    $fp = fsockopen($host, 85, $errno, $errstr, 30);
	 
	    if ($fp){
	 
	        // send the request headers:
	        fputs($fp, "POST $path HTTP/1.1\r\n");
	        fputs($fp, "Host: $host\r\n");
	 		
	        if ($referer != '')
	            fputs($fp, "Referer: $referer\r\n");
	 
	        fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
	        fputs($fp, "Content-length: ". strlen($data) ."\r\n");
	        fputs($fp, "Connection: close\r\n\r\n");
	        fputs($fp, $data);
	 
	        $result = ''; 
	        while(!feof($fp)) {
	            // receive the results of the request
	            $result .= fgets($fp, 128);
	        }
	    }
	    else { 
	        return array(
	            'status' => 'err', 
	            'error' => "$errstr ($errno)"
	        );
	    }
	 
	    // close the socket connection:
	    fclose($fp);
	 
	    // split the result header from the content
	    $result = explode("\r\n\r\n", $result, 2);
	 
	    $header = isset($result[0]) ? $result[0] : '';
	    $content = isset($result[1]) ? $result[1] : '';

		//return content only
		return $content;

	}

	public static function getAllContacts(){
		//return array
		return json_decode(self::send_data_post(array('getcontacts' => '')),true);
	}

	public static function getMessages($number){
		//return array
		return json_decode(self::send_data_post(array('getmessages' => $number)),true);
	}

	public static function sendMessages($number,$text){
		//return array
		return json_decode(self::send_data_post(array('sendmessages' => $number,'text' => $text)),true);
	}

}