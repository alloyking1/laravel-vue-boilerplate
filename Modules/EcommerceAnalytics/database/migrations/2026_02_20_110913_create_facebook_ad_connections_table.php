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
        Schema::create('facebook_ad_connections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ad_account_id')->constrained()->onDelete('cascade');
            $table->text('access_token');
            $table->string('facebook_ad_account_id');
            $table->string('facebook_business_id')->nullable();
            $table->timestamp('token_expires_at')->nullable();
            $table->json('permissions')->nullable();
            $table->json('account_info')->nullable(); // Store account details from Facebook API
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facebook_ad_connections');
    }
};
