<?php

namespace BDGO;
/*
	BDGOSMS Class v2.0
	For BDGOSMS.COM Rest API
	Jafran Hasan
*/

if (!class_exists('SMS')) {
	class SMS
	{
		private  		$maxLength = 160;
		private 		$key = null;
		protected 		$number = null;
		protected 		$message = null;
		protected 		$apiUrl = 'https://www.bdgosms.com/send/';

		public function __construct($key = null)
		{
			if ($key)
				$this->key = $key;
			return $this;
		}

		public function __call($method, $args)
		{
			return $this;
		}

		public static function __callStatic($method, $args)
		{
			return new static;
		}

		// set numbers
		public function setNumber($number = false)
		{
			if ($number)
				$this->number = $number;
			// $this->number = $this->formatize($number);
			return $this;
		}

		// set message text
		public function setMessage($message = false)
		{
			if ($message)
				$this->message = urlencode(substr($message, 0, $this->maxLength));
			return $this;
		}

		// send sms and make curl request
		public function send()
		{

			if (!$this->number || !$this->message || !$this->key)
				return [$this->number, $this->message, $this->key];

			$requestURL = $this->apiUrl .  '?req=out&apikey=' . $this->key . '&numb=' . $this->number . '&sms=' . $this->message;

			// php curl
			$requestCURL = curl_init($requestURL);
			curl_setopt($requestCURL, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($requestCURL, CURLOPT_POST, 0);
			$requestResult = json_decode(curl_exec($requestCURL));
			$result = $requestResult->status == 'Sms sent successfully' ? true : false;
			curl_close($requestCURL);

			return $result;
		}


		// formatizer and sanitzation method for security reason
		private static function formatize($number)
		{
			$number = str_replace(['+88'], '', $number);

			if (is_numeric($number) && strlen($number) == 11) {
				$numArr = str_split($number);
				if ($numArr[0] == 0 && $numArr[1] == 1 && $numArr[2] > 2) {
					return $number;
				}
			}
			return false;
		}


		/*
		Developed by Jafran Hasan
		FullStack Software Developer
		Contact for more details at http://facebook.com/iamjafran
		I'm none of BDGOSMS, I've just used their service personally, made this REST API Class for personal usage and released as Open Source. 
	*/
	}
}
