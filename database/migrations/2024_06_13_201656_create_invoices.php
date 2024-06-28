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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string("total");
            $table->string("discount");
            $table->string("vat");
            $table->string("payable");
            $table->unsignedBigInteger("user_id");
            $table->foreign('user_id')->references("id")->on('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->unsignedBigInteger("customer_id");
            $table->timestamp("created_at")->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};
