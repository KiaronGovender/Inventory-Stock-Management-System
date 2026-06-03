<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->string('sku')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('unit')->default('pcs');
            $table->unsignedInteger('quantity')->default(0);
            $table->unsignedInteger('low_stock_threshold')->default(5);
            $table->decimal('price', 12, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['category_id', 'is_active']);
            $table->index(['quantity', 'low_stock_threshold']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
