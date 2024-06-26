<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mst_product', function (Blueprint $table) {
            $table->increments('product_id');
            $table->string('product_name',255);
            $table->string('product_image',255)->nullable();
            $table->double('product_price', 12, 1)->default(0);
            $table->tinyInteger('is_sales');
            $table->text('description')->nullable();							
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_product');
    }
};
