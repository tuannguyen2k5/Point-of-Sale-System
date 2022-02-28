<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('warehouse_id');
            $table->unsignedInteger('customer_id');
            $table->date('order_date');
            $table->decimal('price', 10, 2);
            $table->decimal('shipping_fee');
            $table->boolean('is_complete')->default(false);
            $table->unsignedInteger('payment_id')->nullable();
            $table->unsignedInteger('delivery_id')->nullable();
            $table->string('note', 200)->nullable();
            $table->timestamps();
        });

        Schema::create('sale_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('payment_type_id')->default(2);
            $table->string('validate_photo')->nullable();
            $table->boolean('payment_status')->default(false);
            $table->timestamps();
        });

        Schema::create('payment_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 40);
            $table->string('description', 200)->nullable();
            $table->timestamps();
        });

        Schema::create('products_of_sale', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sale_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('quantity');
            $table->timestamps();
        });

        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('status_id');
            $table->decimal('received_money', 10, 2);
            $table->string('note', 200)->nullable();
            $table->timestamps();
        });

        Schema::create('delivery_status', function (Blueprint $table) {
            $table->id();
            $table->string('name', 40);
            $table->string('description', 200)->nullable();
            $table->timestamps();
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique('email_index');
            $table->string('phone', 50);
            $table->string('photo')->nullable();
            $table->string('address', 200);
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
        Schema::dropIfExists('sales');
        Schema::dropIfExists('products_of_sale');
        Schema::dropIfExists('sale_payments');
        Schema::dropIfExists('payment_types');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('deliveries');
        Schema::dropIfExists('delivery_status');
    }
}
