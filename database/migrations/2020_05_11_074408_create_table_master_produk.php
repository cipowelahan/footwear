<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMasterProduk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_produk', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('kategori_id')->nullable();
            $table->string('kode', 190)->unique();
            $table->string('nama', 190);
            $table->string('merk', 190);
            $table->string('warna', 190);
            $table->string('ukuran', 190);
            $table->text('foto')->nullable();
            $table->text('deskripsi')->nullable();
            $table->integer('stok')->default(0);
            $table->integer('harga_jual')->default(0);
            $table->integer('harga_beli')->default(0);
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();

            $table->foreign('kategori_id')
                ->references('id')
                ->on('m_produk_kategori')
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
        Schema::dropIfExists('m_produk');
    }
}
