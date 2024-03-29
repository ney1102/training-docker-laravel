<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mst_users', function (Blueprint $table) {
            $table->integer('id',10)->autoIncrement();
            $table->string('name',255);
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken('remember_token')->nullable();
            $table->string('verify_email',100)->nullable();
            $table->string('group_role',50);
            $table->tinyInteger('is_active');
            $table->tinyInteger('is_delete');
            $table->timestamp('last_login_at',$precision = 0)->nullable();
            $table->char('last_login_ip',40)->nullable();
            $table->timestamp('created_at',$precision = 0)->nullable();
            $table->timestamp('updated_at',$precision = 0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_users');
    }
};
