<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesticidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesticides', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('crop_id');
            $table->date('application_date');
            $table->string('type');
            $table->integer('amount'); // 農薬の量を保存
            $table->text('note')->nullable();
            $table->timestamps();

            // 外部キー制約
            $table->foreign('crop_id')->references('id')->on('crops')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesticides');
    }
}

