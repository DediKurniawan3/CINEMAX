
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->id();

            $table->foreignId('studio_id')
                ->constrained('studios')
                ->cascadeOnDelete();

            $table->string('row', 5);
            $table->unsignedSmallInteger('seat_number');
            $table->timestamps();

            $table->unique(['studio_id', 'row', 'seat_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
