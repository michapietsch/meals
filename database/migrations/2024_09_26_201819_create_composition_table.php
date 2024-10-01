<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('composition', function (Blueprint $table) {
            $table->id();

            $table->morphs('composable');
            $table->morphs('parent');

            $table->decimal('amount')->nullable();
            $table->string('unit')->nullable();

            $table->timestamps();
        });
    }
};
