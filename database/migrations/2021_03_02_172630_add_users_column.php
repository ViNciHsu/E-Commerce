<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsersColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // 加入新欄位
            $table->integer('user_level',)
                ->default(0)
              ->after('password');
            $table->integer('add',)
                ->default(0);
            $table->integer('edit',)
                ->default(0);
            $table->integer('delete',)
                ->default(0);
            $table->string('address_county',255);
            $table->string('address_city',255);
            $table->string('address_zip',255);
            $table->string('address_street',255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
