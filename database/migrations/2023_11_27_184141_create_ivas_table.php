<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ivas', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->decimal('por', 4, 2);
            $table->timestamps();
        });
        DB::table('ivas')->insert([
            ['tipo' => 'General', 'por' => 21.0],
            ['tipo' => 'Reducido', 'por' => 10.0],
            ['tipo' => 'Súperreducido', 'por' => 4.00],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ivas');
    }
};
