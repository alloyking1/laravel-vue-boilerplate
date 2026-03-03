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
        Schema::create('ecommerce_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('business_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('connected_store_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('transaction_type', ['sale', 'refund', 'expense', 'ad_spend'])->index();
            $table->string('source')->index(); // shopify_order, facebook_ad, manual, etc.
            $table->string('external_id')->nullable()->index();
            $table->decimal('amount', 15, 2);
            $table->string('currency', 3)->default('USD');
            $table->text('description')->nullable();
            $table->timestamp('transaction_date')->index();
            $table->json('raw_data')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'transaction_type']);
            $table->index(['connected_store_id', 'transaction_date']);
            $table->index(['external_id', 'source']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ecommerce_transactions');
    }
};
