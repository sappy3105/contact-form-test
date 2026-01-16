<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('first_name', 8);
            $table->string('last_name', 8);
            $table->tinyInteger('gender')->comment('1:男性 2:女性 3:その他');
            $table->string('email');
            $table->string('tel', 15);
            $table->string('address');
            $table->string('building')->nullable(); // 建物名は任意入力のためnullable
            $table->text('detail', 120);
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
        Schema::dropIfExists('contacts');
    }
}
