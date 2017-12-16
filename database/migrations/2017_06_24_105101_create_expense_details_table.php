<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExpenseDetailsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_details', function (Blueprint $table) {
            $table->string('id', 100);
            $table->string('expense_id', 100);
			$table->date('date');
			$table->string('who')->nullable();
			$table->float('dollar')->nullable();
            $table->float('khmer')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('expense_details');
    }
}
