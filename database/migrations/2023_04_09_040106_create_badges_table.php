<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBadgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('badge_icon')->default('default_badge_icon.png');
            $table->integer('necessary_rizz_points_start')->default(0);
            $table->integer('necessary_rizz_points_end')->default(0);
            $table->integer('necessary_accuracy_start')->default(0);
            $table->integer('necessary_accuracy_end')->default(0);
            $table->integer('necessary_streak_start')->default(0);
            $table->integer('necessary_streak_end')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('badges');
    }
}
