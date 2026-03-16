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
        Schema::create('shopify_connections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('connected_store_id')->constrained()->onDelete('cascade');
            $table->string('shop_domain')->unique();
            $table->text('access_token');
            $table->string('shopify_store_id')->nullable();
            $table->json('scopes')->nullable();
            $table->timestamp('token_expires_at')->nullable();
            $table->json('shop_info')->nullable(); // Store shop details from Shopify API
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shopify_connections');
    }
};
