<?php

namespace App\Forms;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactForm {

	/**
	 * Form validation rules
	 *
	 * @return array
	 */
	public static function validationRules() {
		return [
			'name' => 'required|string|max:' . Contact::NAME_MAX_LENGTH,
			'lastname' => 'string|max:' . Contact::LASTNAME_MAX_LENGTH,
			'phones.*' => 'string|max:' . Contact::PHONES_MAX_COUNT,
		];
	}
	
	/**
	 * Form limits
	 *
	 * @return array
	 */
	public static function limits () {
		return [
			'phones_max_count' => Contact::PHONES_MAX_COUNT,
			'phone_max_length' => Contact::PHONE_MAX_LENGTH,
			'name_max_length' => Contact::NAME_MAX_LENGTH,
			'lastname_max_length' => Contact::LASTNAME_MAX_LENGTH,
		];
	}
	
	/**
	 * Normalization params
	 * @param array $data
	 */
	public static function normalization(array &$data) {
		foreach($data as $param_name=>$param_value) {
			switch($param_name) {
				case 'phones': 
					if (!empty($data[$param_name]) && is_array($data[$param_name])) {
						$data[$param_name] = array_map('trim', $data[$param_name]);
						$data[$param_name] = array_diff($data[$param_name], ['', null, 0]);
						$data[$param_name] = array_values($data[$param_name]);
					}
				break;
				
				case 'name':
				case 'lastname': 	
					if (is_null($data[$param_name])) {
						$data[$param_name] = '';
					}
				break;
				
			}	
		}
		
	}
	/**
	 * Request the data
	 * 
	 * @param Request $request
	 * @return array
	 */
	public static function requestData(Request $request): array {
		//Attention: writes NULL for empty params
		$request_data = $request->only(['name', 'lastname', 'phones']);
		self::normalization($request_data);
		
		return $request_data;
	}
}
