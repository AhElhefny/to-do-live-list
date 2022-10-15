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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name',255)->nullable();
            $table->text('description')->nullable();
            $table->enum('type',[0,1])->default(0)->comment('0=>public,1=>private');
            $table->tinyInteger('status')->default(0)->comment('0=>pending');
            $table->string('image',255)->nullable();
            $table->unsignedBigInteger('user_id');
            $table->enum('blocked',[0,1])->default(0)->comment('0=>unblocked,1=>blocked');
            $table->text('block_description')->nullable();
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
        Schema::dropIfExists('groups');
    }
};
