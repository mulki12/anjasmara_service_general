<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategoriJasaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kategori_jasa', function (Blueprint $table) {
            $table->id();
            $table->string('kode_jasa')->unique();
            $table->string('nama_jasa');
            $table->string('action');
            $table->string('icon_jasa')->nullable();
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
        Schema::dropIfExists('kategori_jasa');
    }
}
