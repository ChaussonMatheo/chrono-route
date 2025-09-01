=<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nom du parcours
            $table->text('description')->nullable(); // Description optionnelle
            $table->dateTime('scheduled_date')->nullable(); // Date prévue
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Assignée à un user
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
