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
            $table->string('id', 100);
			$table->string('wedding_id', 100);
			$table->string('guest_id', 100);
			$table->integer('dollar')->default(0);
			$table->integer('khmer')->default(0);
			$table->string('other', 255)->nullable();
			$table->string('record_from', 35)->default('web');
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
