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
        Schema::create('patient_chronic_diseases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("patient_id")->nullable();
            $table->unsignedBigInteger("disease_id")->nullable();
            // $table->foreign("disease_id")->references("id")->on("diseases");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_chronic_diseases');
    }
};
