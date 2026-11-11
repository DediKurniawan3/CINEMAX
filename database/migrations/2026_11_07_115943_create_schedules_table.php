
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('film_id')
                ->constrained('films')
                ->restrictOnDelete();

            $table->foreignId('studio_id')
                ->constrained('studios')
                ->restrictOnDelete();

            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->decimal('price', 12, 2);

            $table->enum('status', [
                'active',
                'cancelled',
                'completed'
            ])->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
