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
        Schema::table('user_statutory_info', function (Blueprint $table) {
            $table->string('previousInsNo')->nullable();
            $table->string('employerCode')->nullable();
            $table->string('nameAddress')->nullable();
            $table->string('employerEmail')->nullable();
            $table->string('nomineeName')->nullable();
            $table->string('nomineeRelationship')->nullable();
            $table->string('nomineeAddress')->nullable();
            $table->string('particularName')->nullable();
            $table->string('particularDateofbirth')->nullable();
            $table->string('particularRelationship')->nullable();
            $table->string('residancePlace')->nullable();
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
};
