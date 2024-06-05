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
        Schema::create('leaves', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->string('leave_type')->nullable();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->string('remaining_leaves')->nullable();
            $table->text('reason')->nullable();
            $table->integer('type')->default(0);
            $table->integer('status')->default(0);
            $table->integer('created_by')->nullable(); 
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
        Schema::dropIfExists('leaves');
    }
};
