<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGuestsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->string('id', 100);
            $table->string('user_id', 100);
            $table->string('guest_group_id', 100);
            $table->string('khmer_name', 100)->nullable();
            $table->string('english_name', 100)->nullable();
            $table->string('phone', 100)->nullable();
            $table->string('print_name', 200)->nullable();
            $table->string('address')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guests');
    }
}
