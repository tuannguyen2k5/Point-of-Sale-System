<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 170)->unique('name_index');
            $table->decimal('price');
            $table->unsignedInteger('quantity')->default(0);
            $table->unsignedInteger('brand_id');
            $table->date('expired_date');
            $table->unsignedInteger('unit_id');
            $table->string('barcode');
            $table->string('type', 10)->default('standard');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('created_by');
            $table->string('photo')->nullable();
            $table->text('description')->nullable();
            $table->boolean('published')->default(true);
            $table->timestamps();
        });
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
        });
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('units');
        Schema::dropIfExists('brands');
    }
}
