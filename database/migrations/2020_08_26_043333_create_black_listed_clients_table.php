<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlackListedClientsTable extends Migration
{

    public function up()
    {
        Schema::create('black_listed_clients', function (Blueprint $table) {
            $table->id();
            $table->string('accountName');
            $table->string('clientType');
            $table->string('institution');
            $table->string('accountManager');
            $table->datetime('date')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('black_listed_clients');
    }
}
