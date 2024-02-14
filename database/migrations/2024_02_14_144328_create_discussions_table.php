<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscussionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discussions', function (Blueprint $table) {
            $table->uuid('id')->primary();
			$table->string('name',100)->nullable()->default(NULL);
			$table->string('description',100)->nullable()->default(NULL);
			$table->uuid('createdBy',100)->nullable()->default(NULL);
			$table->string('lastMessage',100)->nullable()->default(NULL);
			$table->string('photoUrl',255)->nullable()->default(NULL);
			$table->longText('members')->nullable()->default(NULL);
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
        Schema::dropIfExists('discussions');
    }
}
