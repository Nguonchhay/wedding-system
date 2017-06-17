<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWeddingInvitationsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wedding_invitations', function (Blueprint $table) {
            $table->string('id', 60);
            $table->string('user_id', 60);
			$table->string('wedding_id', 60);
			$table->string('guest_id', 60);
			$table->string('print_name', 100)->nullable();
			$table->integer('dollar')->default(0);
			$table->integer('khmer')->default(0);
			$table->integer('bat')->default(0);
			$table->integer('dong')->default(0);
			$table->string('other', 255)->nullable();
			$table->string('dowry')->nullable();
			$table->string('record_from', 35)->default('input');
			$table->string('qrcode', 100)->nullable();
			$table->string('code', 8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wedding_invitations');
    }
}
