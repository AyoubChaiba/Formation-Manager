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
        Schema::create('contact_beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->constrained('contact_target_groups')->onDelete('cascade');
            $table->foreignId('beneficiarie_id')->constrained('beneficiaries')->onDelete('cascade');
            $table->string('url')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_beneficiaries');
    }
};
