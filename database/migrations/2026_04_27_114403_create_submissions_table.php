<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('submissions');

        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Logbook header fields
            $table->string('reagent_name');

            // Logbook row fields
            $table->string('sr_no');
            $table->date('received_date');
            $table->string('quantity');
            $table->string('kept_by');
            $table->date('kept_date');
            $table->string('drawn_by');
            $table->date('drawn_date');
            $table->decimal('balance', 10, 2);
            $table->string('remarks')->nullable();

            // Review fields
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('review_note')->nullable();
            $table->string('checked_by')->nullable();
            $table->date('inventory_date')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};