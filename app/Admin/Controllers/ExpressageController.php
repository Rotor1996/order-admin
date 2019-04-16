<?php

namespace App\Admin\Controllers;

use App\Models\Client;
use App\Models\Expressage;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Auth;
use Encore\Admin\Facades\Admin;

class ExpressageController extends Controller
{
    use HasResourceActions;
    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */

    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
      //  $data=Auth::guard('admin')->user()->toArray();
//        $data=Admin::user()->permissions;
//        var_dump($data);
       $grid = new Grid(new Expressage);
       $grid->disableCreateButton();
       $grid->filter(function($filter){
    		// 去掉默认的id过滤器
   			 $filter->disableIdFilter();
    		// 在这里添加字段过滤器
     		$filter->like('ID', 'id');
	 		$filter->like('client.name', '客户姓名');
     		$filter->like('client.phone', '手机');
     		$filter->like('client.service', '归属客服');
         	$filter->like('supervise_teacher', '督导老师');
         	$filter->date('client.order_time', '下单时间');
});
        $grid->status('状态')->select(Expressage::getStatus());
        $grid->courier_name('快递公司')->editable();
        $grid->odd_numbers('快递单号')->editable();
//        $grid->column('client.id','订单id');
//        $grid->column('标题')->expand(function () {
//            return 123;
//        });
        $grid->column('client.name','客户姓名');
        $grid->column('client.gender','性别')->display(function ($type){
            switch ($type) {
                case '1':
                    return '男';
                case '0':
                    return '女';
                default:
                    return '未知';
            };
        });
		$grid->column('client.money','定金/全款')->label('info');
        $grid->column('client.pay_way','支付方式')->using(Expressage::getMoneyWay())->label();
        $grid->column('client.phone','手机');
        $grid->column('client.addres','收货地址')->style('max-width:100px;word-break:break-all;');
        $grid->column('client.product','产品类型')->map('ucwords')->implode(',')->style('max-width:100px;word-break:break-all;');
        $grid->column('client.money_way','尾款支付方式')->using(Expressage::getMoneyEndWay())->label();
        $grid->column('client.money_end_way','尾款金额')->label('info');
        $grid->column('client.order_time','下单时间');
        $grid->column('client.remark','备注')->style('max-width:300px;word-break:break-all;');
        $grid->column('client.service','归属客服');
        $grid->supervise_teacher('督导老师')->editable();
        $grid->footer(function (){
            //查询订单总额
            $sum=Expressage::sum('sum');//总
            $untreated=Expressage::where('status',0)->sum('sum'); //未处理
            $abnormal=Expressage::where('status',1)->sum('sum');//异常
            $send_back=Expressage::where('status',2)->sum('sum');// const STATE_SEND_BACK_STRING = '已退回仓库';
            $suggest_return=Expressage::where('status',3)->sum('sum');//const STATE_SUGGEST_RETURN_STRING = '建议退回';
            $sign_in=Expressage::where('status',4)->sum('sum');//const STATE_SIGN_IN_STRING = '已签收';
            $check=Expressage::where('status',5)->sum('sum');//const STATE_CHECK_STRING = '已审核';
            $shipments=Expressage::where('status',6)->sum('sum');//const STATE_SHIPMENTS_STRING = '已发货';
            //dd($sum);
            return "<div style='padding:10px;'>
                        <div><span>总业绩： $sum 元 </span><span style='padding-left: 50px; padding-right: 50px;'>建议退回：$suggest_return 元 </span><span>已退回订单：$send_back 元 </span></div>
                        <div><span>已签收订单：$sign_in 元  </span><span style='padding-left: 30px; padding-right: 37px;'>已审核订单：$check 元  </span><span>已发货订单：$shipments 元  </span></div>
                        <div><span>未处理订单：$untreated 元  </span><span style='padding-left: 30px; padding-right: 51px;'>异常订单：$abnormal 元  </span><span>实际业绩：</span></div>
                     </div>";
        });
        return $grid;

    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Expressage::findOrFail($id));
        $show->id('Id');
        $show->expressage_id('Expressage id');
        $show->status('Status');
        $show->courier_name('Courier name');
        $show->odd_numbers('Odd numbers');
        $show->created_at('Created at');
        $show->updated_at('Updated at');
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $gender=[
            'on'  => ['value' => 0, 'text' => '女', 'color' => 'danger'],
            'off' => ['value' => 1, 'text' => '男', 'color' => 'primary'],
        ];
        $form = new Form(new Expressage);
        $form->select('status','状态')->options(Expressage::getStatus());
        $form->text('courier_name','快递公司');
        $form->text('odd_numbers','快递单号');
        $form->text('client.name', '客户姓名');
        $form->switch('client.gender','性别')->states($gender);
        $form->decimal('client.money', '定金/全款');
        $form->select('client.pay_way', '支付方式')->options(Expressage::getMoneyWay());
        $form->mobile('client.phone', '手机');
        $form->text('client.addres', '收货地址');
        $form->checkbox('client.product', '产品类型')->options(['赢在家教'=>'赢在家教','护眼灯' =>'护眼灯','正姿护眼笔' =>'正姿护眼笔','机器人'=>'机器人','10寸手写板'=>'10寸手写板','十倍速学习法超强记忆'=>'十倍速学习法超强记忆','一分钟奇趣作文'=>'一分钟奇趣作文','一分钟奇趣数学'=> '一分钟奇趣数学','一分钟奇趣英语'=> '一分钟奇趣英语','汉唐模型解题法初中作文'=> '汉唐模型解题法初中作文','汉唐模型解题法初中英语'=> '汉唐模型解题法初中英语','汉唐模型解题法初中数学' => '汉唐模型解题法初中数学','新CES学习法高中作文'=>'新CES学习法高中作文','新CES学习法高中数学'=>'新CES学习法高中数学','新CES学习法高中英语'=>'新CES学习法高中英语','其他'=>'其他']);
        $form->decimal('client.money_end_way', '尾款');
        $form->select('client.money_way', '尾款支付方式')->options(Expressage::getMoneyEndWay());
        $form->date('client.order_time', '下单时间')->default(date('Y-m-d'));
        $form->text('client.wechat', '归属微信');
        $form->date('client.add_fans_time', '加粉日期')->default(date('Y-m-d'));
        $form->text('client.source', '来源');
        $form->text('client.remark','备注');
        $form->text('client.service', '归属客服');
      	$form->text('supervise_teacher','督导老师');
        $form->saved(function(Form $form){
            $data=Auth::guard('admin')->user()->toArray();
            $id = $form->model()->clients_id;
            $money=$form->model()->client->money;
            $money_end_way=$form->model()->client->money_end_way;
            $sum=$money+$money_end_way;
            Expressage::where('clients_id',$id)->update(['sum'=>$sum]);
            return redirect('/admin/order-all');
        });
        return $form;
    }
}
