<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->integer('fk_users_role', false)->unsigned();
            $table->string('first_name', 64);
            $table->string('last_name', 64);
            $table->string('image')->nullable()->default(NULL);
            $table->string('email', 64)->unique();
            $table->string('password', 64);
            $table->string('phone')->nullable();
            $table->rememberToken();
            $table->tinyInteger('is_active')->default(1)->comment('1=> Active, 0=> In Active');
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->timestamp('created_at')->nullable()->default(NULL);
            $table->timestamp('deleted_at')->nullable();
            $table->foreign('fk_users_role')->references('id')->on('users_role')->onDelete('cascade')->onUpdate('cascade');
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
