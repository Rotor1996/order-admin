<?php

namespace App\Admin\Controllers;

use App\Models\Client;
use App\Models\Expressage;
use App\Http\Controllers\Controller;
use Encore\Admin\Admin;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
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
            ->header('添加订单')
            ->description('加油，又有订单了呢！')
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
            ->header('添加订单')
            ->description('加油！又有订单了呢！')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Client);
        $grid->id('Id');
        $grid->name('客户姓名');
        $grid->gender('性别')->display(function ($type){
            switch ($type) {
                case '1':
                    return '男';
                case '0':
                    return '女';
                default:
                    return '未知';
            };
        });
        $grid->money('定金/全款');
        $grid->pay_way('支付方式');
        $grid->phone('手机');
        $grid->addres('地址');
        $grid->product('产品类型')->map('ucwords')->implode(',');
        $grid->money_end_way('尾款支付方式');
        $grid->money_way('尾款金额');
        $grid->order_time('下单时间');
        $grid->wechat('归属微信');
        $grid->add_fans_time('加粉时间');
        $grid->source('来源');
        $grid->remark('备注');
        $grid->service('归属客服');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

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
        $show = new Show(Client::findOrFail($id));

        $show->id('Id');
        $show->name('Name');
        $show->gender('Gender');
        $show->money('Money');
        $show->pay_way('Pay way');
        $show->phone('Phone');
        $show->addres('Addres');
        $show->product('Product');
        $show->money_end_way('Money end way');
        $show->money_way('Money way');
        $show->order_time('Order time');
        $show->wechat('Wechat');
        $show->add_fans_time('Add fans time');
        $show->source('Source');
        $show->service('Service');
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
      $data=Auth::guard('admin')->user()->toArray();
        $gender=[
            'on'  => ['value' => 0, 'text' => '女', 'color' => 'danger'],
            'off' => ['value' => 1, 'text' => '男', 'color' => 'primary'],
        ];
        $form = new Form(new Client);
        $form->text('name', '客户姓名');
        $form->switch('gender','性别')->states($gender);
        $form->decimal('money', '定金/全款');
        $form->select('pay_way', '请选择支付方式')->options(Expressage::getMoneyWay());
        $form->mobile('phone', '手机');
        $form->text('addres', '收货地址');
        $form->checkbox('product', '产品类型')->options(['赢在家教' =>'赢在家教','护眼灯'=>'护眼灯','正姿护眼笔'=>'正姿护眼笔','机器人'=>'机器人','10寸手写板'=>'10寸手写板','十倍速学习法超强记忆'=>'十倍速学习法超强记忆','一分钟奇趣作文'=>'一分钟奇趣作文','一分钟奇趣数学'=> '一分钟奇趣数学','一分钟奇趣英语'=> '一分钟奇趣英语','汉唐模型解题法初中作文'=> '汉唐模型解题法初中作文','汉唐模型解题法初中英语'=> '汉唐模型解题法初中英语','汉唐模型解题法初中数学' => '汉唐模型解题法初中数学','新CES学习法高中作文'=>'新CES学习法高中作文','新CES学习法高中数学'=>'新CES学习法高中数学','新CES学习法高中英语'=>'新CES学习法高中英语']);
        $form->decimal('money_end_way', '尾款');
        $form->select('money_way', '请选择支付方式')->options(Expressage::getMoneyWay());
        $form->date('order_time', '下单时间')->default(date('Y-m-d'));
        $form->text('wechat', '归属微信');
        $form->date('add_fans_time', '加粉日期')->default(date('Y-m-d'));
        $form->text('source', '来源');
        $form->text('remark','备注');
        $form->text('service', '归属客服')->default($data['username']);
      
    
        $form->saved(function(Form $form){
          $data=Auth::guard('admin')->user()->toArray();
               $id = $form->model()->id;
               Expressage::create(['clients_id'=>$id]);
          return redirect('/admin/order-all?&client%5Bservice%5D='.$data['username']);
        });
        return $form;

    }
}
