<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUploadsLists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload_list', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('upload_time')->useCurrent();
            $table->string('name', 45)->nullable();
        });
        
        Schema::create('domain', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('domain_name', 255)->nullable();
        });
        
        Schema::create('upload_domain', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->unsignedBigInteger('domain_id')->index();
            $table->foreign('domain_id')->references('id')->on('domain')
                ->onUpdate('cascade')->onDelete('cascade');
            
            $table->unsignedBigInteger('upload_list_id')->index();
            $table->foreign('upload_list_id')->references('id')->on('upload_list')
                ->onUpdate('cascade')->onDelete('cascade');
        });
        
        Schema::create('domain_contact', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('domain_id')->index();
            
            $table->string('first_name', 45)->nullable();
            $table->string('last_name', 45)->nullable();
            $table->string('email', 100)->nullable();
            $table->tinyInteger('confidence')->nullable();
            
            $table->foreign('domain_id')->references('id')->on('domain')
                ->onUpdate('cascade')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
