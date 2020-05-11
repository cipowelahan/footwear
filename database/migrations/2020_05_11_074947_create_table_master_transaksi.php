<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMasterTransaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_transaksi', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('supplier_id')->nullable();
            $table->date('tanggal');
            $table->enum('jenis', ['penjualan', 'pembelian'])->default('penjualan');
            $table->bigInteger('total')->default(0);
            $table->string('user', 190)->nullable();

            $table->foreign('supplier_id')
                ->references('id')
                ->on('m_supplier')
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
        Schema::dropIfExists('tr_transaksi');
    }
}
