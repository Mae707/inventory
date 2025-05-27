<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExpiryDateToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
{
    Schema::table('products', function (Blueprint $table) {
        $table->date('expiry_date')->nullable()->after('qty'); // or 'datetime' instead of 'date'
    });
}

public function down()
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn('expiry_date');
    });
}
}
