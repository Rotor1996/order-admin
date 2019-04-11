<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpressagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expressages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('clients_id')->comment('订单ID');
            $table->unsignedInteger('status')->comment('状态:1未处理，2异常3，已退回仓库，4，建议退回，5，已签收，6，已审核，7，已发货');
            $table->string('courier_name')->comment('快递公司名称');
            $table->string('odd_numbers')->comment('快递单号');
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
        Schema::dropIfExists('expressages');
    }
}
