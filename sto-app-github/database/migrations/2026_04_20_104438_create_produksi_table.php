<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produksi', function (Blueprint $table) {
            $table->id();
            $table->string('line', 50);
            $table->string('part_number', 50);
            $table->string('part_name', 255);
            $table->integer('qty_system')->default(0);
            $table->integer('qty_aktual')->default(0);
            $table->integer('gap')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produksi');
    }
};