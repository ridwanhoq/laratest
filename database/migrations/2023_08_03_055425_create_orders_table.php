<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->string('service_frequency')->default('once')->comment('[once, daily]');
            $table->decimal('grand_total', 20, 2)->default(0);
            $table->timestamp('started_at')->default(now());
            $table->timestamp('expired_at')->default(now());
            $table->timestamp('return_expired_at')->default(now());
            $table->boolean('is_invoice_created')->default(false);
            $table->boolean('is_invoice_sms_sent')->default(false);
            $table->unique(['service_frequency', 'client_id']); // if already invoice created then should allow to create a new invoice for once orders
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
        Schema::dropIfExists('orders');
    }
}
