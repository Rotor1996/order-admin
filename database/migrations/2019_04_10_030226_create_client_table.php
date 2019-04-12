<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('客户姓名');
            $table->tinyInteger('gender')->comment('性别 1男性，0女性');
            $table->unsignedDecimal('money')->comment('金额');
            $table->string('pay_way')->comment('支付方式');
            $table->string('phone')->comment('电话');
            $table->string('addres')->comment('地址');
            $table->string('product')->comment('产品类型');
            $table->string('money_end_way')->comment('尾款支付方式');
            $table->unsignedDecimal('money_way')->comment('尾款金额');
            $table->date('order_time')->comment('下单时间');
            $table->string('wechat')->comment('归属微信');
            $table->date('add_fans_time')->comment('加粉时间');
            $table->string('source')->comment('来源');
            $table->string('remark')->comment('备注');
            $table->string('service')->comment('客服');
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
        Schema::dropIfExists('client');
    }
}
