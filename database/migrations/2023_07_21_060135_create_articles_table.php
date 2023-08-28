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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(\App\Models\User::class)->index()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Tag::class)->index()->constrained()->cascadeOnDelete();

            $table->string('title');
            $table->longText('content');

            $table->string('status')->index();
            $table->boolean('allow_comments')->default(true);

            $table->timestamp('publish_time')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
