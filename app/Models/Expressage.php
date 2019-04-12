<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expressage extends Model
{
    const STATE_UNTREATED=0;//未处理
    const STATE_ABNORMAL=1;//异常
    const STATE_SEND_BACK=2;//已退回仓库
    const STATE_SUGGEST_RETURN=3;//建议退回
    const STATE_SIGN_IN=4;//已签收
    const STATE_CHECK=5;//已审核
    const STATE_SHIPMENTS=6;//已发货
    const STATE_UNTREATED_STRING = '未处理';
    const STATE_ABNORMAL_STRING = '异常';
    const STATE_SEND_BACK_STRING = '已退回仓库';
    const STATE_SUGGEST_RETURN_STRING = '建议退回';
    const STATE_SIGN_IN_STRING = '已签收';
    const STATE_CHECK_STRING = '已审核';
    const STATE_SHIPMENTS_STRING = '已发货';
    const MONEY_WAY_WECHAT=1;//微信
    const MONEY_WAY_ALIPAY=2;//支付宝
    const MONEY_WAY_ICBC=3;//工行
    const MONEY_WAY_CCB=4;//建行
    const MONEY_WAY_BOC=5;//中行
    const MONEY_WAY_CMB=6;//招行
    const MONEY_WAY_COMM=7;//交行
    const MONEY_WAY_ABC=8;//农行
    const MONEY_WAY_PSBC=9;//邮政
    const MONEY_WAY_ELSE=10;//其他
    const MONEY_WAY_PAY_ON_DELIVERY=11;//货到付款
    const MONEY_WAY_WECHAT_STRING='微信';
    const MONEY_WAY_ALIPAY_STRING='支付宝';
    const MONEY_WAY_ICBC_STRING='工行';
    const MONEY_WAY_CCB_STRING='建行';
    const MONEY_WAY_BOC_STRING='中行';
    const MONEY_WAY_CMB_STRING='招行';
    const MONEY_WAY_COMM_STRING='交行';
    const MONEY_WAY_ABC_STRING='农行';
    const MONEY_WAY_PSBC_STRING='邮政';
    const MONEY_WAY_ELSE_STRING='其他';
    const MONEY_WAY_PAY_ON_DELIVERY_STRING='货到付款';
    protected $fillable = [
        'clients_id','status', 'courier_name', 'odd_numbers','supervise_teacher'
    ];
    public function client()
    {
        return $this->belongsTo(Client::class,'clients_id');
       // return $this->belongsTo(Client::class,'id');
    }
    public static function getStatus(){
        return[
            self::STATE_UNTREATED=>self::STATE_UNTREATED_STRING,
            self::STATE_ABNORMAL=>self::STATE_ABNORMAL_STRING,
            self::STATE_SEND_BACK=>self::STATE_SEND_BACK_STRING,
            self::STATE_SUGGEST_RETURN=>self::STATE_SUGGEST_RETURN_STRING,
            self::STATE_SIGN_IN=>self::STATE_SIGN_IN_STRING,
            self::STATE_CHECK=>self::STATE_CHECK_STRING,
            self::STATE_SHIPMENTS=>self::STATE_SHIPMENTS_STRING,
        ];
    }
    public static function getMoneyWay(){
        return[
         self::MONEY_WAY_WECHAT=>self::MONEY_WAY_WECHAT_STRING,
         self::MONEY_WAY_ALIPAY=>self::MONEY_WAY_ALIPAY_STRING,
         self::MONEY_WAY_ICBC=>self::MONEY_WAY_ICBC_STRING,
         self::MONEY_WAY_CCB=>self::MONEY_WAY_CCB_STRING,
         self::MONEY_WAY_BOC=>self::MONEY_WAY_BOC_STRING,
         self::MONEY_WAY_CMB=>self::MONEY_WAY_CMB_STRING,
         self::MONEY_WAY_COMM=>self::MONEY_WAY_COMM_STRING,
         self::MONEY_WAY_ABC=>self::MONEY_WAY_ABC_STRING,
         self::MONEY_WAY_PSBC=>self::MONEY_WAY_PSBC_STRING,
         self::MONEY_WAY_ELSE=>self::MONEY_WAY_ELSE_STRING,
         self::MONEY_WAY_PAY_ON_DELIVERY=>self::MONEY_WAY_PAY_ON_DELIVERY_STRING,
        ];
    }
    public static function getMoneyEndWay(){
        return[
         self::MONEY_WAY_WECHAT=>self::MONEY_WAY_WECHAT_STRING,
         self::MONEY_WAY_ALIPAY=>self::MONEY_WAY_ALIPAY_STRING,
         self::MONEY_WAY_ICBC=>self::MONEY_WAY_ICBC_STRING,
         self::MONEY_WAY_CCB=>self::MONEY_WAY_CCB_STRING,
         self::MONEY_WAY_BOC=>self::MONEY_WAY_BOC_STRING,
         self::MONEY_WAY_CMB=>self::MONEY_WAY_CMB_STRING,
         self::MONEY_WAY_COMM=>self::MONEY_WAY_COMM_STRING,
         self::MONEY_WAY_ABC=>self::MONEY_WAY_ABC_STRING,
         self::MONEY_WAY_PSBC=>self::MONEY_WAY_PSBC_STRING,
         self::MONEY_WAY_ELSE=>self::MONEY_WAY_ELSE_STRING,
         self::MONEY_WAY_PAY_ON_DELIVERY=>self::MONEY_WAY_PAY_ON_DELIVERY_STRING,
        ];
    }
}
