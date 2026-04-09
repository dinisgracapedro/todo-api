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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // id
            $table->string('title'); // título da task
            $table->text('description')->nullable(); // descrição da task (pode ser nula)
            $table->boolean('is_completed')->default(false); // status da task
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // relação com usuários
            $table->timestamps(); // created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
