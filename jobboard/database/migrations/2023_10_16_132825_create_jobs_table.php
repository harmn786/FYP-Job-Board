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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employer_id')->constrained('employers')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('title');
            $table->string('location');
            $table->foreignId('job_type_id')->constrained('job_types')->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('education');
            $table->string('experience');
            $table->Integer('salary');
            $table->string('gender');
            $table->integer('vacancy');
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('application_deadline');
            $table->text('description');
            $table->text('other_requirements');
            $table->text('other_benifits')->nullable();
            $table->string('company_email');
            $table->string('company_name');
            $table->string('company_image')->nullable();
            $table->boolean('approved_by_admin')->default(false);
            $table->boolean('featured')->default(false);
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
