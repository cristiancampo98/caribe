<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remissions', function (Blueprint $table) {
            $table->id();
            $table->decimal('delivered',7,3);
            $table->foreignId('order_details_id')->constrained();
            $table->foreignId('vehicle_users_id')->nullable()->constrained();
            $table->foreignId('created_by')->constrained('users');
            $table->boolean('isSigned')->default(0);
            $table->boolean('available')->default(0);
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
        Schema::dropIfExists('remissions');
    }
}
