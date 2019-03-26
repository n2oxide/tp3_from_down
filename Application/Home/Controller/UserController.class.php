<?php

namespace Home\Controller;


use http\Client\Curl\User;
use Think\Controller;
use Think\Exception;

class UserController extends Controller
{
    public function read()
    {
        $User = D('Users');
        $arg['id'] = array('GT', I('get.id'));
        $user = $User->where($arg)->find();

        dump($user);
    }

    public function create()
    {
        $this->display();
    }

    //新增用户
    public function save()
    {
        //表单提交途径
        if (IS_POST && !IS_AJAX) {
            $User = D('Users');
            $data['id'] = I('post.id');
            $data['name'] = I('post.name');
            //自动验证，完成
            if (!$User->create($data)) {
                exit($User->getError());
            } else {
                $id = $User->fetchSql(false)->add();
                $user = $User->find($id);
                dump($user);
            }
        }
        //AJAX提交途径
        if (IS_POST && IS_AJAX) {
            $User = D('Users');
            $data['id'] = I('request.id');
            $data['name'] = I('request.name');
            //自动验证，完成
            if (!$User->create($data)) {
                $this->ajaxReturn(array('error' => $User->getError()));
            } else {
                //抛出PDO错误
                try {
                    $data = $User->fetchSql(false)->add();
                } catch (Exception $exception) {
                    $this->ajaxReturn(array('error' => $exception));
                }
                //成功并返回用户信息
                $result['success'] = $User->find($data);
                $this->ajaxReturn($result);
            }
        }
    }

    //编辑用户页面
    public function edit()
    {
        $user = D('Users')->find(I('get.id'));

        if ($user !== false && !empty($user)) {
            $this->assign('user',$user);
            $this->display();
        } else {
            dump('用户不存在');
        }
    }

    //编辑用户
    public function update()
    {
        $User = D('Users');
        if (IS_POST && !IS_AJAX) {
            if (!$User->create()) {
                dump($User->getError());
            }

            $result = $User->save();
            if ($result!==false){
                dump('success'.$result);
            }

            dump($User->getDbError());
            dump($User->getLastSql());
        }
    }
}