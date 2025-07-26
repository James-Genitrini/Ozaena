<?php

// database/migrations/xxxx_xx_xx_create_cart_items_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('size', 10); // Ajout colonne taille
            $table->unsignedInteger('quantity');
            $table->timestamps();

            $table->unique(['cart_id', 'product_id', 'size']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};