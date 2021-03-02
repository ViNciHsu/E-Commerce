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
            $table->integer('user_level')
                ->default(0);
            $table->integer('add')
                ->default(0);
            $table->integer('edit')
                ->default(0);
            $table->integer('delete')
                ->default(0);
            $table->string('address_county')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_zip')->nullable();
            $table->string('address_street')->nullable();
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
            $table->dropColumn('user_level');
            $table->dropColumn('add');
            $table->dropColumn('edit');
            $table->dropColumn('delete');
            $table->dropColumn('address_county');
            $table->dropColumn('address_city');
            $table->dropColumn('address_zip');
            $table->dropColumn('address_street');
        });
    }
}
