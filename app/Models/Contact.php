<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model {

	public const PHONES_MAX_COUNT = 20;
	public const PHONE_MAX_LENGTH = 30;
	public const NAME_MAX_LENGTH = 127;
	public const LASTNAME_MAX_LENGTH = 127;
	
	protected $fillable = [
		'name',
		'lastname',
		'phones',
	];
	protected $casts = [
		'phones' => 'array',
	];
	
	
}
