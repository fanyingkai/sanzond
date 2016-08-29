<?php
namespace Admin\Model;

class ContentModel extends BaseModel {
    //自动验证
    protected $_validate = array(
        array('name','require','内容类型名称不得为空！',self::MUST_VALIDATE),
        array('logicname','require','内容模型逻辑名不能为空',self::MUST_VALIDATE),
        array('name',0,'内容类型名称不得重复',self::MUST_VALIDATE,'unique',self::MODEL_BOTH),
        array('logicname',0,'内容逻辑名称不得重复',self::MUST_VALIDATE,'unique',self::MODEL_BOTH),
    );
    
    //自动完成
    protected $_auto = array(
        //自动设置为可用
        array('is_active','1'),
        //设置添加时间
        array('date_joined','auto_date_now',self::MODEL_INSERT,'callback'),
    );
    
    protected function _after_insert($data, $options) {
        //创建内容模型逻辑文件
        $fileurl = MODULE_PATH.'Logic/'.ucfirst($data['logicname']).'Logic.class.php';
        $phpfile = fopen($fileurl,'w');
        $a = '$_validate';
        $b = '$_auto';
        $text = <<<EOT
<?php
namespace Admin\Logic;

class {name}Logic extends BaseLogic {
    protected  $a= array(
        array('name','require','名称不得为空！',self::MUST_VALIDATE),
        array('name',0,'名称不得重复',self::MUST_VALIDATE,'unique',self::MODEL_BOTH),
    );

    //自动完成
    protected $b = array(
        array('date_joined','auto_date_now',self::MODEL_INSERT,'callback'),
        array('date_update','auto_date_now',self::MODEL_UPDATE,'callback'),
        array('founder_uid','getuid',self::MODEL_INSERT,'callback'),
        array('founder','getusername',self::MODEL_INSERT,'callback'),
        array('updater_uid','getuid',self::MODEL_UPDATE,'callback'),
        array('updater','getusername',self::MODEL_UPDATE,'callback'),
    );
}
EOT;
        $text = str_replace('{name}', $data['logicname'], $text);
        fwrite($phpfile, $text);
        fclose($fileurl);
        
        //创建相关数据库
        $sql = <<<EOT
CREATE TABLE {tablename} (
  id int(11) NOT NULL,
  secid int(11) NOT NULL,
  name varchar(36) NOT NULL,
  description varchar(255) NOT NULL,
  is_active int(1) NOT NULL,
  is_hot int(1) NOT NULL,
  is_recommend int(1) NOT NULL,
  date_joined varchar(10),
  date_update varchar(10),
  date_release varchar(10) NOT NULL,
  founder_uid int(11) NOT NULL,
  founder varchar(48) NOT NULL,
  updater_uid int(11) NOT NULL,
  updater varchar(48) NOT NULL,
  sort int(6) NOT NULL,
  PRIMARY KEY (id)
);
EOT;
        $tablename = C('DB_PREFIX').$data['logicname'];
        $remark = $data['name']."内容模型";
        $sql = str_replace('{tablename}', $tablename, $sql);
        $sql = str_replace('{remark}', $remark, $sql);
        M()->execute($sql);
        
        /*创建相应的View模板页面
        $addurl = MODULE_PATH.'View/'.C('DEFAULT_THEME').'/add'.$data['logicname'];
        $editurl = MODULE_PATH.'View/'.C('DEFAULT_THEME').'/add'.$data['logicname'];
        $listurl = MODULE_PATH.'View/'.C('DEFAULT_THEME').'/add'.$data['logicname'];
        $texthtml = '<extend name="Public:base" />';
        
        $addfile = fopen($addurl, 'w');
        fwrite($addfile, $texthtml);
        fclose($addfile);
        
        $editfile = fopen($editurl, 'w');
        fwrite($editfile, $texthtml);
        fclose($editfile);
        
        $listfile = fopen($listurl, 'w');
        fwrite($listfile, $texthtml);
        fclose($listfile);*/
        //添加相应的操作规则
        $rules[0]['name']  = $data['logicname']."/C";
        $rules[0]['title'] = $data['name']."添加操作";
        $rules[0]['status']= '1';
        $rules[1]['name']  = $data['logicname']."/U";
        $rules[1]['title'] = $data['name']."编辑操作";
        $rules[1]['status']= '1';
        $rules[2]['name']  = $data['logicname']."/D";
        $rules[2]['title'] = '删除'.$data['name'].'操作';
        $rules[2]['status']= '1';
        M('auth_rule')->addAll($rules);
    }
}