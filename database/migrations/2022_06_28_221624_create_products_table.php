<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id');
            $table->foreign('seller_id')->references('id')->on('users');
            $table->string('title');
            $table->mediumText('short_desc');
            $table->longText('long_desc');
            $table->string('category');
            $table->timestamp('creation_time')->useCurrent();
            $table->timestamp('pre_timer')->nullable();
            $table->timestamp('current_timer')->nullable();
            $table->float('current_bid', 8, 2)->nullable();
            $table->float('increment', 8, 2)->nullable();
            $table->integer('bid_level')->nullable();
            $table->timestamp('sold_timer')->nullable();
            $table->timestamp('del_timer')->nullable();
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
        Schema::dropIfExists('products');
    }
};
