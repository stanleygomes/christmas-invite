<?php

use App\Http\Controllers\bo\ProducersBO;

class helpers {

	protected $ProducersBO;

	public function __construct (ProducersBO $producersBO) {
		$this->producersBO = $producersBO;
	}

	public static function dotToComma ($string) {

		return str_replace(".", ",", $string);
	}

	public static function dateUStoBR ($date, $format, $datetime = false) {

		if($date != ''){
			if($datetime == true)
				return date_create_from_format('Y-m-d h:i:s', $date)->format($format);
			else
				return date_create_from_format('Y-m-d', $date)->format($format);
		}
		else
			return '';
	}
	
	public static function limitText ($string, $max) {

		return strlen($string) < $max ? $string : substr($string, 0, $max).'...';
	}

	public static function getProducerActive () {

		return 'ALTERAR PRODUTOR';
	}
}