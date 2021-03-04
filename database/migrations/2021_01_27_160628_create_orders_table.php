<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id') ->constrained();
            $table->string('shipping_address',100);
            $table->string('department',50);
            $table->string('city',50);
            $table->string('pse_url')->nullable();
            $table->string('pse_number')->nullable();
            $table->text('note')->nullable();
            $table->text('delete_note')->nullable();
            $table->enum('status',['activo','finalizado','cancelado']);
            $table->foreignId('created_by') ->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
