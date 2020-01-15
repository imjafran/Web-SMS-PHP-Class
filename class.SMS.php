<?php
/*
	Send SMS Class v1.0
	For BDGOSMS.COM Rest API
	Jafran Hasan
*/
if( !class_exists('SMS') ) {
	class SMS {
		private 		$key = 'YOUR_API_KEY';  // change your key here
		protected 		$numbers = false;
		protected 		$message = false;
		protected 		$bulk = false;
		private static 	$delay = 2000; // 2000ms  ; BDGOSMS Defined Delay for Each HTTP Request
		private static 	$execution_time = 300; // 300 seconds

		// security classes
		public function __call( $method, $args)
		{
			return $this;
		}

		public function __callStatic( $method, $args)
		{
			return new static;
		}
		
		
		// set numbers
		public function setNumbers( $numbers = false )
		{
			if( $numbers ){
				if( !is_array($numbers) ) {
					$numbers = explode(',', $numbers);
				}

				$numbs = [];
				foreach ($numbers as $numb) {
					if( self::formatize($numb) ) {
						$this->numbers[] = self::formatize($numb);
					} else {
						continue;
					}
				}
			}			
			return $this;
		}
	
		// set message text
		public function setMessage( $message = false )
		{
			if( $message ) {
				if( strlen( $message ) > 250 ) {
					$this->message = urlencode( substr( $message, 0, 250 ) );
				} else {
					$this->message = urlencode( $message );
				}
			}
			return $this;
		}


		// set bulk sms
		public function setBulk( $bulk = false )
		{	
			if( $bulk && is_array($bulk) ) {
				foreach ($bulk as $number => $text) {
					if( self::formatize($number) ) {
						$this->bulk[] = [$number, urlencode( $text )];
					}
				}
			}

			return $this;
		}
		
		// send sms and make curl request
		public function send()
		{

			$all_results = [];
			$actionSet = [];

			if( $this->numbers && $this->message ) {
				foreach ( $this->numbers as $number ) {
					$actionSet[] = [$number, $this->message];
				}
			}

			if( $this->bulk ) {
				 if( $actionSet == null ) {
				 	$actionSet = $this->bulk;
				 } else {
				 	$actionSet = array_merge($actionSet, $this->bulk);
				 }
			}

			// final execution 
			if( $actionSet != null ){

				// increasing maximum execution time for bulk hit
				set_time_limit(self::$execution_time); 

				foreach ($actionSet as $action) {	
					$requestURL = 'https://www.bdgosms.com/send/?req=out&apikey=' . $this->key . '&numb=' . $action[0] . '&sms=' . $action[1]; // bdgosms request url											
					// easy curl
					$requestCURL = curl_init( $requestURL ); 
					curl_setopt( $requestCURL, CURLOPT_RETURNTRANSFER, 1 );
					$requestResult = json_decode(curl_exec( $requestCURL ));
					curl_close( $requestCURL );
					$all_results[$action[0]] = $requestResult->status ?? 'Error';

					// HTTP Request Delay
					if(count($actionSet) > 1){
						sleep(self::$delay);
					}	
				}

				return $all_results;
			}
			return false;
		}


		// formatizer and sanitzation method for security reason
		private static function formatize( $number )
		{
			$number = str_replace(['+88'], '', $number);
			
			if( is_numeric($number) && strlen($number) == 11 ) {
				$numArr = str_split($number);
				if($numArr[0] == 0 && $numArr[1] == 1 && $numArr[2] > 2){
					return $number;
				}
			}
			return false;
		}


	/*
		Developed by Jafran Hasan
		FullStack Web Application Developer
		Contact for more details at http://facebook.com/iamjafran
		I'm none of BDGOSMS, I've just used their service personally, made this REST API Class for personal usage and released as Open Source. 
	*/
	}
}
