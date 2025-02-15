<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('origin_id');
            $table->string('name');
            $table->string('gtin');
            $table->unsignedInteger('quantity');
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
