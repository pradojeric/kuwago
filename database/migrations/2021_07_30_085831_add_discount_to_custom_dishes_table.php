<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountToCustomDishesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('custom_dishes', function (Blueprint $table) {
            //
            $table->string('discount_no')->nullable()->after('price');
            $table->float('discount')->nullable()->after('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('custom_dishes', function (Blueprint $table) {
            //
            $table->dropColumn('discount_no');
            $table->dropColumn('discount');
        });
    }
}
