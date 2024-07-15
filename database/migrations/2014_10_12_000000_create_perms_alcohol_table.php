<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermsAlcoholTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perms_alcohol', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('colonie')->nullable();
            $table->string('perm1')->nullable();
            $table->string('perm2')->nullable();
            $table->string('perm3')->nullable();
            $table->string('perm4')->nullable();
            $table->string('perm5')->nullable();
            $table->string('perm6')->nullable();
            $table->string('perm7')->nullable();
            $table->string('perm8')->nullable();
            $table->string('perm9')->nullable();
            $table->string('perm10');
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
        Schema::dropIfExists('perms_alcohol');
    }
}
