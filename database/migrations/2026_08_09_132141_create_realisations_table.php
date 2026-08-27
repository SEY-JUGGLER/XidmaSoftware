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
        Schema::create('realisations', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('slug')->unique();
            $table->string('client');
            $table->string('secteur');
            $table->text('probleme');
            $table->text('solution');
            $table->text('resultats');
            $table->string('image_cover')->nullable();
            $table->foreignId('service_id')->constrained()->restrictOnDelete();
            $table->date('date_realisation');
            $table->boolean('publie')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('realisations');
    }
};
