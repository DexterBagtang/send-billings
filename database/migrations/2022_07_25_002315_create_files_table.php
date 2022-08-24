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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->integer('clients_id')->nullable();
            $table->string('filename');
            $table->string('storedFile');
            $table->string('month');
            $table->string('year');
            $table->string('uploader');
            $table->string('emailStatus');
            $table->dateTime('emailDate')->nullable();
            $table->string('emailedBy')->nullable();
            $table->longText('subject')->nullable();
            $table->softDeletes();
            $table->string('deletedBy')->nullable();
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
        Schema::dropIfExists('files');
    }
};
