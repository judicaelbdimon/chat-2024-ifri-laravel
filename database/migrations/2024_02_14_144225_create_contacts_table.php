<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
			$table->uuid('user1Id',100)->nullable()->default(NULL);
			$table->uuid('user2Id',100)->nullable()->default(NULL);
			$table->string('user1blocked',100)->nullable()->default(NULL);
			$table->string('user2blocked',100)->nullable()->default(NULL);
            $table->enum('status',array('pending','validated','revoked'))->nullable()->default(NULL);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
