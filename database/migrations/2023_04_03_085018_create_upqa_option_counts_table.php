<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpqaOptionCountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upqa_option_counts', function (Blueprint $table) {
            $table->id();
            $table->integer('pq_id')->nullable();
            $table->integer('pqa_option_id')->nullable();
            $table->integer('count')->default(0)->min(0);
            $table->integer('percentage')->default(0)->min(0)->max(100);
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
        Schema::dropIfExists('upqa_option_counts');
    }
}
