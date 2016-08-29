<?php
namespace Admin\Controller;

use Think\Page;
class ContentController extends AdminController{
    protected $ctm;
    
    public function _initialize() {
        parent::_initialize();
        $this->ctm = D('content');
    }
    
    public function index() {
        $ctmlist = $this->ctm->select();
        $this->assign('ctmlist',$ctmlist);
        $this->display();
    }
    
    public function editCTM($id) {
        $ctminfo = $this->ctm->where(array('id'=>$id))->find();
        $this->assign('ctminfo',$ctminfo);
        $this->display();
    }
    
    /*
     * 渲染内容模型对应的添加，修改，列表页面
     * $logic:模型逻辑名称
     * $action:执行的操作，add.edit,list
     * $id:用于edit操作
     */
    public function ctmdisplay($logic,$action,$id='') {
        $logictpl = $this->ctm->field('alisttpl,aaddtpl,aedittpl')->where(array('logicname'=>$logic))->find();
        if(empty($logictpl)) {
            $this->error('内容模型不存在,无法找到对应列表模板');
        } else {
            $tpl = ($logictpl["a".$action."tpl"]=="")?$action.$logic:$logictpl["a".$action."tpl"];
        }
        $lista = 'list'.$logic;
        switch ($action) {
            case 'edit':
                $model = D($logic,'Logic');
                $ctminfo = D($logic,'Logic')->where(array('id'=>$id))->find();
                $other = $model->displayeditother($id);
                $this->assign('other',$other);
                $this->assign('ctminfo',$ctminfo);
                break;
            case 'list':
                $model = D($logic,'Logic');
                $map = array('is_active'=>array('NEQ','3'));
                $count = $model->where($map)->count();
                $fena = 8;
                $page = new \Think\Page($count,$fena);
                foreach ($map as $key=>$val){
                    $page->parameter[$key]=urlencode($val);
                }
                $show = $page->show();
                $ctmlist = M($logic)->where($map)->order('date_joined desc')->limit($page->firstRow.','.$page->listRows)->select();
                $other = $model->displaylistother();
                $this->assign('other',$other);
                $this->assign($lista,$ctmlist);
                $this->assign('page',$show);
                $this->assign('fena',$fena);
                break;
            case 'add':
                break;
            default:break;
        }
        $sections = D('Sections');
        $sectionList = $sections->sectionstree();
        $this->assign('sectionList',$sectionList);
        $this->display($tpl);
    }
    
    public function ctmsearch($logic) {
        //实例化内容模型
        $Model = D($logic,'Logic');
        //寻找模板
        $logictpl = $this->ctm->field('alisttpl,aaddtpl,aedittpl')->where(array('logicname'=>$logic))->find();
        if(empty($logictpl)) {
            $this->error('内容模型不存在,无法找到对应列表模板');
        } else {
            //如无指定模板按默认规则
            $tpl = ($logictpl["alisttpl"]=="")?'list'.$logic:$logictpl["alisttpl"];
        }
        $secid = I('secid','');
        $keyword = I('keyword','');
        //每个内容模型需要实现一个search方法
        //进行分页处理
        $a = $Model->search($secid,$keyword);
        $count = $a['count'];
        $page = new Page($count,16);
        foreach ($a['map'] as $k=>$v) {
            $page->parameter[$k] = urlencode($v);
        }
        $show = $page->show();
        $ctmlist = $Model->where($a['map'])->order('date_joined desc')->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('list'.$logic,$ctmlist);
        $this->assign('secid',$secid);
        //栏目分类
        $other = $Model->displaylistother();
        $this->assign('other',$other);
        $sections = D('Sections');
        $sectionList = $sections->sectionstree();
        $this->assign('sectionList',$sectionList);
        $this->assign('page',$show);
		$this->assign('keyword',$keyword);
        $this->display('list'.$logic);
    }
    
    public function test2() {
        $a = D('article','Logic');
        //var_dump($a);die;
        //获取相关模型的所有字段
        var_dump($a->getDbFields());
    }
}