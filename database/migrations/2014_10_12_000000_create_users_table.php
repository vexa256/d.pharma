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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('EmpID')->nullable();
            $table->string('Title')->nullable();
            $table->string('role')->default('superadmin');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();;
            $table->rememberToken();
            $table->timestamps();
        });

        \DB::table('users')->insert([
            'name' => 'Ayebare Timothy',
            'email' => 'vexa256@gmail.com',
            'password' => '$2y$10$LOaCmmBIlMbZXWAkOilLve.ilVz0nFMG7ZtnifLRioG/JyB3QArqe',
        ]);
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
};
