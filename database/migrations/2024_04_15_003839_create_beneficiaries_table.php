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
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('target_group_id')->constrained('target_groups')->onDelete('cascade');
            $table->foreignId('program_id')->constrained('programs')->onDelete('cascade')->after('target_group_id');
            $table->integer('ppr')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('workplace');
            $table->enum('gender', ['male', 'female']);
            $table->string('phone_number')->unique();
            $table->string('email')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiaries');
    }
};
