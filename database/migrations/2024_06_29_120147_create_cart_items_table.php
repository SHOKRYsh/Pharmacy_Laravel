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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("cart_id");
            $table->unsignedBigInteger("drug_id");
            $table->integer("quantity");
            $table->double("price");
            $table->foreign("cart_id")->references("id")->on("carts")->onDelete('cascade');
            $table->foreign("drug_id")->references("id")->on("drugs")->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
