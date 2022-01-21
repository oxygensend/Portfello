<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses_history', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('expenses_id');
            $table->foreign('expenses_id')->references('id')->on('expenses')->constrained()->cascadeOnDelete();
            $table->bigInteger('action');
            $table->float('amount');
            $table->string('item')->nullable();
            $table->string('title');

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
