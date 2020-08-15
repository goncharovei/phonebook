<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Contact;

class CreateContactsTable extends Migration {

	protected $table_name = 'contacts';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create($this->table_name, function (Blueprint $table) {
			$table->id();
			$table->bigInteger('user_id')->unsigned();
			$table->string('name', Contact::NAME_MAX_LENGTH);
			$table->string('lastname', Contact::LASTNAME_MAX_LENGTH)->default('');
			$table->json('phones')->nullable();
			$table->timestamps();
			
			$table->foreign('user_id', 'fk_contacts_to_users')
					->references('id')->on('users')
					->onUpdate('cascade')
					->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists($this->table_name);
	}

}
