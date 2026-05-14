<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_reports', function (Blueprint $table) {
            $table->id();
            $table->string('ref')->nullable();
            $table->string('subject');
            $table->string('location');
            $table->boolean('assigned')->default(false);
            $table->string('assigned_name')->nullable();
            $table->string('assigned_initials')->nullable();
            $table->string('priority');
            $table->string('status')->default('NEW');
            $table->date('report_date');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_reports');
    }
};
