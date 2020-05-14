<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTransaksiKeuangan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_keuangan', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('transaksi_id')->nullable();
            $table->unsignedInteger('kas_id')->nullable();
            $table->unsignedInteger('asset_id')->nullable();
            $table->date('tanggal');
            $table->enum('jenis', ['masuk', 'keluar'])->default('masuk');
            $table->string('keterangan', 190)->nullable();
            $table->bigInteger('total');
            $table->string('sisa_kas', 190)->default(0);

            $table->foreign('transaksi_id')
                ->references('id')
                ->on('tr_transaksi')
                ->onDelete('set null')
                ->onUpdate('cascade');
            
            $table->foreign('kas_id')
                ->references('id')
                ->on('tr_kas')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('asset_id')
                ->references('id')
                ->on('tr_asset')
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
        Schema::dropIfExists('tr_keuangan');
    }
}
