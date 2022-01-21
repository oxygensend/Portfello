<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses_histories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('expense_id');
            $table->foreign('expense_id')->references('id')->on('expenses')->constrained()->cascadeOnDelete();
            $table->bigInteger('action');
            $table->double('amount');
            $table->string('item')->nullable();
            $table->string('title');
            $table->boolean('isLatest')->default(true);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses_history');
    }
}
