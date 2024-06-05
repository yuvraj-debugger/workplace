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
        Schema::create('modules_functions', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->integer('module_id')->nullable();
            $table->integer('sub_module_id')->nullable();
            $table->integer('type')->default(0);
            $table->integer('status')->default(0);
            $table->integer('created_by')->default(0);
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
        Schema::dropIfExists('modules_functions');
    }
};
