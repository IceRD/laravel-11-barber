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
        Schema::create('partners', function (Blueprint $table) {
            $table->id();

            // Имя партнера (ИП)
            $table->string('organization')->nullable();

            // ИНН компании
            $table->string('inn', 12)->nullable();

            // Название филиала
            $table->string('name');

            // Номер договора
            $table->string('contract_number', 50)->unique();

            // Почта
            $table->string('email')->nullable();

            // Телефонные номера
            $table->json('telnums')->nullable();

            // Адрес организации
            $table->string('address')->nullable();

            // Дата подписания договора
            $table->date('start_at')->nullable();

            // Yclients ID
            $table->string('yclients_id')->nullable();

            // Статус партнера вкл/выкл
            $table->boolean('disabled')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
