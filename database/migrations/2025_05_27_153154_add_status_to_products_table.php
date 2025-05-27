<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
  public function up()
{
    Schema::table('products', function (Blueprint $table) {
        $table->string('status')->default('active')->after('qty'); // or after 'price' etc.
    });
}

public function down()
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}

}
