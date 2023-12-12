<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatedColumnMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function ($table) {
            $table->text('body')->nullable()->change();
            $table->string('author')->nullable()->change();
            $table->string('sender_name')->nullable()->change();
            $table->integer('message_number')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function ($table) {
            $table->text('body')->change();
            $table->string('author')->change();
            $table->string('sender_name')->change();
            $table->integer('message_number')->change();
        });
    }
}
