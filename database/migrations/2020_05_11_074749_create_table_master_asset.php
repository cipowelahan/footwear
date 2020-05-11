<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMasterAsset extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_asset', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('kategori_id')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('nama', 190);
            $table->bigInteger('harga_beli')->default(0);

            $table->foreign('kategori_id')
                ->references('id')
                ->on('m_asset_kategori')
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
        Schema::dropIfExists('m_asset');
    }
}
