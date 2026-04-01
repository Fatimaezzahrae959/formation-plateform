<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('formations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('title_fr');
            $table->string('title_en');
            $table->string('slug_fr')->nullable();
            $table->string('slug_en')->nullable();
            $table->text('short_desc_fr')->nullable();
            $table->text('short_desc_en')->nullable();
            $table->text('desc_fr')->nullable();
            $table->text('desc_en')->nullable();
            $table->text('full_desc_fr')->nullable();
            $table->text('full_desc_en')->nullable();
            $table->string('image')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->string('duration')->nullable();
            $table->string('level')->nullable();
            $table->enum('status', ['brouillon', 'publie', 'archive'])->default('brouillon');
            $table->date('publication_date')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->string('seo_title_fr')->nullable();
            $table->string('seo_title_en')->nullable();
            $table->string('meta_desc_fr')->nullable();
            $table->string('meta_desc_en')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formations');
    }
};