<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUopqaPubResSubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uopqa_pub_res_subs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('pq_id')->nullable();
            $table->integer('pqa_option_id')->nullable();
            $table->date('date')->default(date('Y-m-d'));
            $table->unique(['user_id', 'pqa_option_id', 'date']);
            $table->boolean('is_ans_match_with_maj_pub')->default(false);
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
        Schema::dropIfExists('uopqa_pub_res_subs');
    }
}
