<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // auteur
            $table->string('title_fr');
            $table->string('title_en');
            $table->string('slug_fr')->unique();
            $table->string('slug_en')->unique();
            $table->longText('content_fr')->nullable();
            $table->longText('content_en')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['brouillon', 'publie', 'archive'])->default('brouillon');
            $table->date('published_at')->nullable();
            $table->string('seo_title_fr')->nullable();
            $table->string('seo_title_en')->nullable();
            $table->string('meta_desc_fr')->nullable();
            $table->string('meta_desc_en')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};