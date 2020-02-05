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
            $table->increments('id');
            $table->string('first_name'); // VARCHAR : prénom
            $table->string('last_name'); // VARCHAR : nom
            $table->string('email')->unique(); // VARCHAR : email (doit être unique dans la base)
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password'); // VARCHAR : mot de passe
            $table->enum('role', ['client', 'admin'])->default('client'); // ENUM : rôle de l'utilisateur (client par défaut)
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
