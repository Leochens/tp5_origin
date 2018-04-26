<?php
namespace app\thing\controller;
use  think\Controller;
use think\Db;

class Api extends Controller
{

    public function index()
    {
        $res = Db::name('thing')->select();
        //var_dump($res);
        $this->assign([
                "test"=>"this is zhl test",
                'json'=>$this->jsonCode(200,'OK',$res)
        ]);
        //var_dump(json_encode($this->res,JSON_FORCE_OBJECT));
        return $this->fetch('index');
    }

    public function add()
    {
        $req = request();
        
        if($req->isPost())
        {
            //var_dump($req->post());
            $data=$req->post();
            if($data['title']=="")
                $data['title']="Leochens:Untitled";

            if(Db::name('thing')->insert($data))
            {
                return $this->jsonCode(200,'add ok');
            }
            else
            {
                return $this->jsonCode(500,'add error');
            }
        }
    }

    public function delete(){
        $req = request();
        var_dump($req->get());
        if($req->isGet())
        {
            if(Db::name('thing')->where('id',$req->get('id'))->delete())
                return $this->jsonCode(200,'delete ok');
            else
                return $this->jsonCode(500,'delete error');

        }
    }
    /**
     * status  状态码
     * msg     返回信息
     * content 结果集合
     */
    private function jsonCode($status,$msg,$content=array())
    {
        $response=array(
            'status'=>$status,
            'msg' =>$msg,
            'content'=>$content
        );
        return json_encode($response);
    }
}
