<?php

// database/migrations/xxxx_xx_xx_create_messages_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id('msg_id');
            $table->foreignId('sender_id')->constrained('users'); // Usuario que envía el mensaje
            $table->foreignId('receiver_id')->constrained('users'); // Usuario que recibe el mensaje
            $table->foreignId('seed_id')->nullable()->constrained('inventories'); // La semilla (si es relevante para el mensaje)
            $table->text('message'); // El contenido del mensaje
            $table->enum('status', ['sent', 'delivered', 'read'])->default('sent'); // Estado del mensaje
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
