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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->morphs('reportable'); // This will work for both Post or Comment
            $table->foreignId('utilisateur_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('date')->useCurrent();
            $table->string('raison');
            $table->foreignId('type_report_id')->constrained('report_types')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
