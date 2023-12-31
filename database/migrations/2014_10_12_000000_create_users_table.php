<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('use_id');
            $table->string('use_name');
            $table->string('use_email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('use_password');
            $table->boolean('use_status');
            $table->foreignId('rol_id')->constrained('rols')->references('rol_id');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
