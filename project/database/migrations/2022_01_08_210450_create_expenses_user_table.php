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
            $table->unsignedBigInteger('user_1_id');
            $table->unsignedBigInteger('user_2_id');
            $table->unsignedBigInteger('expenses_id');
            $table->foreign('user_1_id')->references('id')->on('users')->constrained()->cascadeOnDelete();
            $table->foreign('user_2_id')->references('id')->on('users')->constrained()->cascadeOnDelete();
            $table->foreign('expenses_id')->references('id')->on('expenses')->constrained()->cascadeOnDelete();
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
