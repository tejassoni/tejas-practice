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
            $table->id();
            $table->string('name')->nullable();
            $table->char('gender',1)->nullable()->comment('m=male,f=female');
            $table->string('mobile',10)->nullable(); // second autoincrement false, third unsigned true 
            $table->string('address')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('hobbies')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');            
            $table->rememberToken();            
            $table->integer('role_id',false,true)->nullable(); 
            $table->tinyInteger('status')->default(1);
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
