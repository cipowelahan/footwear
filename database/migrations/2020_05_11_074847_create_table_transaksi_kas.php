<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTransaksiKas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_kas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('kategori_id')->nullable();
            $table->date('tanggal')->nullable();
            $table->enum('jenis', ['pengeluaran', 'pemasukan'])->default('pengeluaran');
            $table->string('nama', 190);
            $table->bigInteger('total')->default(0);

            $table->foreign('kategori_id')
                ->references('id')
                ->on('m_kas_kategori')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tr_kas');
    }
}
