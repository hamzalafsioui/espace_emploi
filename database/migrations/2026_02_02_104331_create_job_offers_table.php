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
        Schema::create('job_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recruiter_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('company_name')->nullable(); // Can override recruiter's company
            $table->string('location')->nullable();
            $table->string('contract_type')->nullable(); // CDI, CDD, Freelance,...
            $table->string('image_path')->nullable();
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_offers');
    }
};
