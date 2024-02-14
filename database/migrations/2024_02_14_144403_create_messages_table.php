<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->uuid('id')->primary();
			$table->longText('text')->nullable()->default(NULL);
			$table->uuid('surveyId',100)->nullable()->default(NULL);
			$table->uuid('senderId',100)->nullable()->default(NULL);
			$table->uuid('discussionId',100)->nullable()->default(NULL);
			$table->uuid('responseToMsgId',100)->nullable()->default(NULL);
			$table->longText('description')->nullable()->default(NULL);
			$table->longText('file')->nullable()->default(NULL);
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
        Schema::dropIfExists('messages');
    }
}
