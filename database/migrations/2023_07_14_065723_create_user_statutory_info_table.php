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
        Schema::create('user_statutory_info', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->enum('esi',['0','1'])->default('0'); 
            $table->string('esi_number')->nullable();
            $table->string('branch_office')->nullable();
            $table->string('dispensary')->nullable();
            $table->enum('previous_employment',['0','1'])->default('0'); 
            $table->enum('nominee_detail',['0','1'])->default('0'); 
            $table->enum('family_particular',['0','1'])->default('0'); 
            $table->enum('residing',['0','1'])->default('0'); 
            $table->enum('pf',['0','1'])->default('0'); 
            $table->enum('uan',['0','1'])->default('0'); 
            $table->enum('pf_scheme',['0','1'])->default('0'); 
            $table->enum('pension_scheme',['0','1'])->default('0'); 
            $table->string('pf_number')->nullable(); 
            $table->date('pf_joinDate')->nullable(); 

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
        Schema::dropIfExists('user_statutory_info');
    }
};
