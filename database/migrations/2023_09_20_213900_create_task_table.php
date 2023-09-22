<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->unsignedBigInteger('author_id')->nullable();
            $table->string('title');
            $table->text('description');
            $table->text('level'); // low, medium, high
            $table->text('status'); // pending, progress, done, completed
            $table->timestamps();

            $table->foreign('assigned_to')
                ->references('id')
                ->on('users')
                ->nullOnDelete('cascade');
            $table->foreign('author_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }    
};
