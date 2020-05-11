<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTransaksiProduk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_transaksi_produk', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('transaksi_id');
            $table->unsignedInteger('produk_id')->nullable();
            $table->integer('jumlah');
            $table->integer('harga');
            $table->bigInteger('total');

            $table->foreign('transaksi_id')
                ->references('id')
                ->on('tr_transaksi')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('produk_id')
                ->references('id')
                ->on('m_produk')
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
        Schema::dropIfExists('tr_transaksi_produk');
    }
}
