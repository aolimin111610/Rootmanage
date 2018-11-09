<?php
namespace app\index\controller;

use app\index\model\Users;
use think\Controller;
use think\Db;
use think\Request;
use think\response\Json;

class Index extends Controller
{
    /*public function index()
    {
        //return '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="ad_bd568ce7058a1091"></think>';
        return $this->fetch();
    }*/
    public function index(){
        //方式一
       /* $list = Db::name('users')->select();
        $this->assign('list',$list);
        return $this->fetch();*/
       //方式二
       $list=Users::all(
           function($query){
               $query->order('id','desc');
           });
       return $this->fetch('',compact('list'));
    }
    public function add(Request $request){
        $data = input('post.');
        $name = $data['name'];
        $content = $data['content'];
       /* if(empty($name)||empty($content)){
            $this->error('留言或者用户名不能为空');
        }*/

        $user = new Users();
        $res = $user->save([
            'name' => $name,
            'content'=>$content,
            'createAt'=>time(),
            'ip'=>$request->ip(),

        ]);
        if($res){
            $dates = Users::all(
                function($query){
                    $query->limt(1)->order('id','desc');
                });
            return json_encode($dates[0]);
        }else{
            return 'error';
        }


       /* if($res){
            $this->success('发布成功！',url('index/index'));
        }else{
            $this->error('发布失败');
        }*/

    }


}
