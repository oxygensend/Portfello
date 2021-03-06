<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses_user', function (Blueprint $table) {
            $table->id();
            $table->double('user_contribution')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('expenses_history_id');

            $table->foreign('user_id')->references('id')->on('users')->constrained()->cascadeOnDelete();
            $table->foreign('expenses_history_id')->references('id')->on('expenses_histories')->constrained()->cascadeOnDelete();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses_user');
    }
}
