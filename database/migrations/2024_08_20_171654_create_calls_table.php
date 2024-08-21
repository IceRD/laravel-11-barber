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
        Schema::create('calls', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('partner_id');

            // Mango телефон
            $table->string('mango_telnum', 12)->nullable();

            // Потерянные клиенты
            $table->integer('lost_client_days')->default(0);

            // Повторные клиенты
            $table->integer('repeat_client_days')->default(0);

            // Новые клиенты
            $table->integer('new_client_days')->default(0);

            // Оплачено до
            $table->date('pay_end')->nullable();

            // ID чата Телеграм
            $table->string('tg_chat_id')->nullable();

            // Статус телеграма вкл/выкл
            $table->boolean('tg_active')->default(false);

            $table->timestamps();

            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calls');
    }
};
