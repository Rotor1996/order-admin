<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name','gender', 'money', 'pay_way','phone','addres','product','money_end_way','money_way','order_time','wechat','add_fans_time','source','service'
    ];
    protected $dates=['order_time','add_fans_time']; //设置对象返回是日期格式。
    public function setProductAttribute($value)
    {
//        $this->attributes['product'] = implode(',', $value);
        $this->attributes['product'] = join(',',$value);
    }
    public function getProductAttribute($value)
    {
        return explode(',', $value);
    }
    public function expressage()
    {
        //return $this->belongsTo(Expressage::class,'expressage_id');
        return $this->belongsTo(Expressage::class,'id');
    }
}
