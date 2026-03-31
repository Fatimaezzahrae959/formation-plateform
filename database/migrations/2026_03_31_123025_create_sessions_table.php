<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    public function up(): void
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('formation_id');
            $table->unsignedBigInteger('formateur_id'); // formateur
            $table->string('title_fr');
            $table->string('title_en');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('capacity')->default(0);
            $table->enum('mode', ['présentiel', 'en ligne', 'hybride']);
            $table->string('city')->nullable();
            $table->string('meeting_link')->nullable(); // si en ligne
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();

            $table->foreign('formation_id')->references('id')->on('formations')->onDelete('cascade');
            $table->foreign('formateur_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
}