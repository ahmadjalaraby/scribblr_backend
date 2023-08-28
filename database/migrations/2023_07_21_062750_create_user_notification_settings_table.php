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
        Schema::create('user_notification_settings', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(\App\Models\User::class)->index()->constrained()->cascadeOnDelete();

            $table->boolean('new_recommendation')->default(true);
            $table->boolean('new_follow')->default(true);
            $table->boolean('new_comment')->default(true);
            $table->boolean('new_mention')->default(true);
            $table->boolean('new_comment_like')->default(true);
            $table->boolean('new_article')->default(true);

            // system
            $table->boolean('app_system')->default(true);
            $table->boolean('guidance_and_tips')->default(true);
            $table->boolean('surveys')->default(true);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_notification_settings');
    }
};
