<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropWarehouseIdFromProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropForeign(['warehouse_id']); // drop FK first
        $table->dropColumn('warehouse_id');
    });
}

public function down()
{
    Schema::table('products', function (Blueprint $table) {
        $table->unsignedInteger('warehouse_id')->nullable()->after('category_id');
        // optionally recreate foreign key if rolling back
        $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('set null');
    });
}

}
