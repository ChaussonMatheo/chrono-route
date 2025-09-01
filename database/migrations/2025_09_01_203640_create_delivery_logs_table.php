<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stop_id')->constrained()->onDelete('cascade'); // lié à un stop
            $table->timestamp('delivered_at')->nullable(); // date/heure de livraison
            $table->enum('status', ['success', 'failed', 'absent'])->default('success'); // état
            $table->text('notes')->nullable(); // remarques
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_logs');
    }
};
