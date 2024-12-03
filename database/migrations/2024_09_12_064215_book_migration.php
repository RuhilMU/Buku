<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('penulis');
            $table->integer('harga');
            $table->date('tgl_terbit');
            $table->string('image')->nullable();
            $table->boolean('editorial_pick')->default(false);
            $table->timestamps();
            $table->boolean('discount')->default(false);
            $table->integer('discount_percentage')->nullable();
        });
    }


    public function down(): void
    {
    }
};
