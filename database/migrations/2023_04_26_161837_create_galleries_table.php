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
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();

            $table->nullableMorphs('loadable');
            $table->index('loadable_id');
            $table->index('loadable_type');

            $table->string('path');
            $table->string('mime')->nullable();
            $table->float('size')->nullable();

            $table->float('width');
            $table->float('height');
            $table->float('aspect_ratio', places: 6);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
