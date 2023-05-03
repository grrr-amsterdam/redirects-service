<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("grrr_redirects", function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("from")->unique();
            $table->string("to");
            $table->boolean("permanently");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("grrr_redirects");
    }
};
