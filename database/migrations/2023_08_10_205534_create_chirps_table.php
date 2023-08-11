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
        Schema::create('chirps', function (Blueprint $table) {
            $table->id();
            //creamos una nueva columna a nuestra table llamda 'user_id'
            //constrained dtermina que la tabla relacionada es user
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            //en nuestra tabla message indicamos que va a tener una capacidad maxima de 255 caracteres
            $table->string('message', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chirps');
    }
};
