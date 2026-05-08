<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('function_id')->nullable()->constrained('functions')->nullOnDelete();
            $table->foreignId('designation_id')->nullable()->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropForeign(['function_id']);
            $table->dropForeign(['designation_id']);
            $table->dropColumn(['department_id', 'function_id', 'designation_id']);
        });
    }
};