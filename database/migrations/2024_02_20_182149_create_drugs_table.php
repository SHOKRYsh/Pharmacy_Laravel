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
        Schema::create('drugs', function (Blueprint $table) {
            $table->id();
            $table->string("name_en")->nullable();
            $table->string("name_ar")->nullable();
            $table->double("new_price")->nullable();
            $table->double("old_price")->nullable();
            $table->string("active_ingredient")->nullable();
            $table->string("company")->nullable();
            $table->string("usage")->nullable();
            $table->string("units")->nullable();
            $table->string("dosage_form")->nullable();
            $table->string("parcode")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drugs');
    }
};
