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
        Schema::create('suggestions', function (Blueprint $table) {
            $table->id();

            // Optional submitter info
            $table->string('name', 150)->nullable();
            $table->string('designation', 150)->nullable();

            // Core content — required
            $table->text('suggestion');

            // Classification / routing
            $table->enum('category', [
                'service_improvement',
                'policy',
                'staff_behavior',
                'facilities',
                'processes',
                'other',
            ])->default('other');

            // Admin workflow
            $table->enum('status', [
                'pending',
                'under_review',
                'acknowledged',
                'implemented',
                'declined',
            ])->default('pending');

            $table->text('admin_notes')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();

            // Soft delete + timestamps
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suggestions');
    }
};
