<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('type', ['in', 'out']);
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('stock_before');
            $table->unsignedInteger('stock_after');
            $table->decimal('unit_cost', 12, 2)->nullable();
            $table->string('reason')->nullable();
            $table->string('reference')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('moved_at');
            $table->timestamps();

            $table->index(['type', 'moved_at']);
            $table->index(['product_id', 'moved_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
