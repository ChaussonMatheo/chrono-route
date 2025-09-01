<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id')->constrained()->onDelete('cascade'); // stop lié à une route
            $table->string('address')->nullable(); // Adresse (si dispo)
            $table->decimal('latitude', 10, 7)->nullable(); // Coord GPS
            $table->decimal('longitude', 10, 7)->nullable(); // Coord GPS
            $table->unsignedInteger('order')->default(0); // Ordre de passage
            $table->boolean('delivered')->default(false); // Statut de livraison
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stops');
    }
};
