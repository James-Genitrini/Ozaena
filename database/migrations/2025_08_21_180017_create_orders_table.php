<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique(); // numéro de commande unique

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Infos client
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email');
            $table->string('phone')->nullable();

            // Adresse
            $table->string('address');
            $table->string('postal_code', 10);
            $table->string('city', 100);
            $table->string('country', 50)->default('FR');

            // Infos commande
            $table->string('status')->default('pending');
            $table->decimal('total', 10, 2);
            $table->text('delivery_note')->nullable();

            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
