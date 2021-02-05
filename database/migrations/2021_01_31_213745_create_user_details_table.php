<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->string('number_identification',15)->Nullable();
            $table->string('type_identification',15)->Nullable();
            $table->string('sex',15)->Nullable();
            $table->string('photo_document')->Nullable();
            $table->string('type_blood',5)->Nullable();
            $table->string('name_company',50)->Nullable();
            $table->string('type_pay',15)->Nullable();
            $table->string('street_address',50)->Nullable();
            $table->string('street_details',50)->Nullable();
            $table->string('street_comune',15)->Nullable();
            $table->string('city')->Nullable();
            $table->string('deparment')->Nullable();
            $table->string('country')->Nullable();
            $table->string('others_email');
            $table->string('phones');
            $table->foreignId('user_id') ->constrained()
            ->onDelete('cascade');
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
        Schema::dropIfExists('user_details');
    }
}
