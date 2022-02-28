<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sale_id');
            $table->string('note', 200)->nullable();
            $table->timestamps();
        });

        Schema::create('old_products_of_return', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('return_sale_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('quantity');
            $table->timestamps();
        });

        Schema::create('new_products_of_return', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('return_sale_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('quantity');
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
        Schema::dropIfExists('return_sales');
        Schema::dropIfExists('old_products_of_return');
        Schema::dropIfExists('new_products_of_return');
    }
}
