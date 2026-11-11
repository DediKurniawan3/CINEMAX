
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('poster')->nullable();
            $table->string('genre');
            $table->unsignedSmallInteger('duration');
            $table->text('synopsis')->nullable();
            $table->string('age_rating', 10)->nullable();
            $table->date('release_date')->nullable();
            $table->enum('status', [
                'coming_soon',
                'now_showing',
                'ended'
            ])->default('now_showing');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('films');
    }
};
