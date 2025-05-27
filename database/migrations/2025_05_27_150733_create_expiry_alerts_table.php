<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpiryAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expiry_alerts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('batch_id');
            $table->unsignedInteger('product_id');
            $table->date('expiry_date');
            $table->integer('days_before_expiry');
            $table->dateTime('alerted_at')->nullable();

            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expiry_alerts');
    }
}
