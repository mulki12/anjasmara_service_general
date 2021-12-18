<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategoriPpobTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kategori_ppob', function (Blueprint $table) {
            $table->id();
            $table->string('kode_ppob');
            $table->string('nama_ppob');
            $table->string('icon_ppob')->nullable();
            $table->string('action')->nullable();
            $table->string('is_published', 1)->default(1);
            $table->integer('set_priority');
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
        Schema::dropIfExists('kategori_ppob');
    }
}
