<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
$menu_r = $this->db->get_one('menu',array('m'=>'core','f'=>'model','v'=>'field_listing'));
$submenuid = $menu_r['menuid'];
?>
<body class="body pxgridsbody">
<link href="<?php echo R;?>css/validform.css" rel="stylesheet">
<script src="<?php echo R;?>js/validform.min.js"></script>
<section class="wrapper">
      <section class="panel">
        <?php echo $this->
          menu($submenuid,'&app='.$m.'&modelid='.$GLOBALS['modelid']);?>
          <div class="panel-body" id="panel-bodys">
            <form name="myform" class="form-horizontal tasi-form" action="" method="post">
            <input type="hidden" value="<?php echo $r['field'];?>" name="oldfield">
              <table class="table table-striped table-advance table-hover">
                <thead>
                  <tr>
                    <th class="tablehead text-end">字段名称</th>
                    <th class="tablehead hidden-phone"><div class="col-sm-4">字段属性</div></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-end">字段类型</td>
                    <td>
                      <div class="col-sm-4">
                          <input type="hidden" name="formtype" value="<?php echo $formtype;?>">
                        <?php echo $form->
                          select($options, $formtype, 'class="form-select"
                          id="formtype" onchange="field_select(this.value)" disabled','请选择字段类型');?>
                      </div>
                    </td>
                  </tr>
                  <?php
                  if($module_config['allow_addto_master']) {
                  ?>
                  <tr>
                    <td class="text-end">添加到主表</td>
                    <td>
                      <div class="col-sm-12">
                      <div class="row">
                          <div class="col-sm-4 d-flex align-items-center">
                              <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="form[master_field]" onclick="alert_warning(1,'master_field')" disabled id="flexRadioDefault3" value="1" <?php if($r['master_field']==1) echo "checked";?>>
                                  <label class="form-check-label" for="flexRadioDefault3">是</label>
                              </div>
                              <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="form[master_field]" id="flexRadioDefault4" value="0" <?php if($r['master_field']==0) echo "checked";?> onclick="alert_warning(0)" disabled>
                                  <label class="form-check-label" for="flexRadioDefault4">否</label>
                              </div>
                          </div>
                        <div class="col-sm-8"><span class="tablewarnings"><i class="icon-info-circle"></i>当列表中调用时，建议添加到主表</span></div>
                      </div>
                      </div>
                    </td>
                  </tr>
                  <?php } else {?>
                      <input type="hidden" name="form[master_field]" value="0">
                  <?php }?>
                  <tr>
                    <td class="text-end">
                      <font color="red">*</font>
                      <strong>字段英文名</strong>
                    </td>
                    <td>
                      <div class="col-sm-12 d-flex">
                        <div class="col-sm-4">
                        <input type="text" name="form[field]" id="field" size="30" class="input-text form-control" datatype="/^[a-zA-Z]{1}([a-zA-Z0-9]|[_]){0,19}$/" errormsg="至少1个字符,最多30个字符！" value="<?php echo $r['field'];?>">
                        </div>
                        <div class="col-sm-8 ps-2">
                        <span class="tablewarnings"><i class="icon-info-circle"></i> 只能由英文字母、数字和下划线组成，并且仅能字母开头</span>
                      </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-end">
                      <font color="red">*</font>
                      <strong>字段别名</strong>
                    </td>
                    <td>
                      <div class="col-sm-4">
                        <input type="text" name="form[name]" id="name" size="30" class="input-text form-control" datatype="*1-20" errormsg="至少1个字符,最多20个字符！" value="<?php echo $r['name'];?>">
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-end">字段提示</td>
                    <td>
                      <div class="col-sm-4">
                        <textarea name="form[remark]" rows="2" cols="20" id="tips" class="form-control"><?php echo $r['remark'];?></textarea>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-end">相关参数</td>
                    <td>
                      <div class="col-sm-12">
                        <?php if(isset($field_config[$formtype][ 'system_field'])) { include $this->
                          core_path.$formtype.'/form_setting.php'; } else { include $this->m_path.$formtype.'/form_setting.php';
                          } ?>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-end">扩展代码</td>
                    <td>
                      <div class="col-sm-12 d-flex">
                        <div class="col-sm-4">
                        <input type="text" name="form[ext_code]" value="<?php echo p_htmlentities($r['ext_code']);?>" size="100" class="input-text form-control" >
                        </div>
                        <div class="col-sm-8 ps-2">
                        <span class="tablewarnings"><i class="icon-info-circle"></i> 可以通过此处向表单加入任何属性</span>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-end">字符长度取值范围</td>
                    <td>
                      <div class="col-sm-12 d-flex">
                          <div class="col-sm-2 pe-2">
                              <div class="input-group">
                                  <span class="input-group-text" id="basic-addon1">最小值：</span>
                                  <input type="text" class="form-control" name="form[minlength]" id="field_minlength" value="<?php echo $r['minlength'];?>" size="5">
                              </div>
                          </div>
                          <div class="col-sm-2 ps-2">
                              <div class="input-group">
                                  <span class="input-group-text" id="basic-addon1">最大值：</span>
                                  <input type="text" class="form-control" name="form[maxlength]" id="field_maxlength" value="<?php echo $r['maxlength'];?>" size="5">
                              </div>
                          </div>
                          <div class="col-sm-8 ps-2">
                            <span class="tablewarnings"><i class="icon-info-circle"></i> 系统将在表单提交时检测数据长度范围是否符合要求，如果不想限制长度请留空</span>
                          </div>
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-end">数据校验正则</td>
                    <td>
                      <div class="col-sm-12 d-flex">
                          <div class="col-sm-2 pe-2">
                            <input type="text" name="form[pattern]" id="pattern" <?php echo $r['pattern'];?> size="40" class="input-text form-control">
                          </div>
                          <div class="col-sm-2 ps-2">
                            <select name="pattern_select" onchange="$('#pattern').val(this.value)" class="form-select">
                            <option value="">常用正则</option>
                            <option value="/^[0-9.-]+$/">数字</option>
                            <option value="/^[0-9-]+$/">整数</option>
                            <option value="/^[a-z]+$/i">字母</option>
                            <option value="/^[0-9a-z]+$/i">数字+字母</option>
                            <option value="/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/">E-mail</option>
                            <option value="/^[0-9]{5,20}$/">QQ</option>
                            <option value="/^http:\/\//">超级链接</option>
                            <option value="/^(1)[0-9]{10}$/">手机号码</option>
                            <option value="/^[0-9-]{6,13}$/">电话号码</option>
                            <option value="/^[0-9]{6}$/">邮政编码</option>
                            </select>
                          </div>
                          <div class="col-sm-8 ps-2">
                          <span class="tablewarnings"><i class="icon-info-circle"></i> 系统将通过此正则校验表单提交的数据合法性，如果不想校验数据请留空</span>
                          </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-end">数据校验未通过的提示信息</td>
                    <td>
                      <div class="col-sm-4">
                        <input type="text" name="form[errortips]" <?php echo $r['errortips'];?> size="50" class="input-text form-control">
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-end">在表单哪个位置显示</td>
                    <td>
                        <div class="col-sm-8">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="form[location]" id="inlineRadio0" value="0" <?php if($r['location']==0) echo "checked";?>>
                                <label class="form-check-label" for="inlineRadio0">基本信息</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="form[location]" id="inlineRadio1" value="1" <?php if($r['location']==1) echo "checked";?>>
                                <label class="form-check-label" for="inlineRadio1">高级设置</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="form[location]" id="inlineRadio2" value="2" <?php if($r['location']==2) echo "checked";?>>
                                <label class="form-check-label" for="inlineRadio2">权限与收费</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="form[location]" id="inlineRadio5" value="5" <?php if($r['location']==5) echo "checked";?>>
                                <label class="form-check-label" for="inlineRadio5">手动表单项</label>
                                <a href="https://www.wuzhicms.com/doc/field-setting-xianshiweizhi.html" target="_blank"><i class="icon-help"></i> 打开帮助页面</a>
                            </div>
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-end">作为搜索条件</td>
                    <td>
                        <div class="col-sm-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="form[search_field]" id="field_allow_search1" value="1" <?php if($r['search_field']==1) echo "checked";?>>
                                <label class="form-check-label" for="field_allow_search1">是</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="form[search_field]" id="field_allow_search0" value="0" <?php if($r['search_field']==0) echo "checked";?>>
                                <label class="form-check-label" for="field_allow_search0">否</label>
                            </div>
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-end">在前台投稿中显示</td>
                    <td>
                      <div class="col-sm-4">
                          <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="form[ban_contribute]" id="ban_contribute1" value="1" <?php if($r['ban_contribute']==1) echo "checked";?> />
                              <label class="form-check-label" for="ban_contribute1">是</label>
                          </div>
                          <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="form[ban_contribute]" id="ban_contribute0" value="0" <?php if($r['ban_contribute']==0) echo "checked";?>/>
                              <label class="form-check-label" for="ban_contribute0">否</label>
                          </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-end">作为全站搜索信息</td>
                    <td>
                      <div class="col-sm-4">
                          <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="form[to_fulltext]" id="to_fulltext1" value="1" <?php if($r['to_fulltext']==1) echo "checked";?>/>
                              <label class="form-check-label" for="to_fulltext1">是</label>
                          </div>
                          <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="form[to_fulltext]" id="to_fulltext0" value="0" <?php if($r['to_fulltext']==0) echo "checked";?>/>
                              <label class="form-check-label" for="to_fulltext0">否</label>
                          </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-end">作为超级字段的附属字段</td>
                    <td>
                        <div class="col-sm-12 d-flex">
                            <div class="col-sm-4">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="form[powerful_field]" id="powerful_field1" value="1" <?php if($r['powerful_field']==1) echo "checked";?>/>
                                    <label class="form-check-label" for="powerful_field1">是</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="form[powerful_field]" id="powerful_field0" value="0" <?php if($r['powerful_field']==0) echo "checked";?>/>
                                    <label class="form-check-label" for="powerful_field0">否</label>
                                </div>
                            </div>
                            <div class="col-sm-8 ps-2">
                                <span class="tablewarnings"><i class="icon-info-circle"></i> 必须与超级字段结合起来使用，否则内容添加的时候不会正常显示</span>
                            </div>
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-end">添加到碎片</td>
                    <td>
                      <div class="col-sm-4">
                          <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="form[to_block]" id="to_block1" value="1" <?php if($r['to_block']==1) echo "checked";?>/>
                              <label class="form-check-label" for="to_block1">是</label>
                          </div>
                          <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="form[to_block]" id="to_block0" value="0" <?php if($r['to_block']==0) echo "checked";?>/>
                              <label class="form-check-label" for="to_block0">否</label>
                          </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-end">工作流字段</td>
                    <td>
                          <div class="col-sm-4">
                            <select name="form[workflow_field]" class="form-select">
                              <option value="0" <?php if($r['workflow_field']==0) echo "selected";?>>默认-发布人可添加</option>
                              <option value="1" <?php if($r['workflow_field']==1) echo "selected";?>>1审人员可添加</option>
                              <option value="2" <?php if($r['workflow_field']==2) echo "selected";?>>2审人员可添加</option>
                              <option value="3" <?php if($r['workflow_field']==3) echo "selected";?>>3审人员可添加</option>
                              <option value="4" <?php if($r['workflow_field']==4) echo "selected";?>>4审人员可添加</option>
                              <option value="5" <?php if($r['workflow_field']==5) echo "selected";?>>5审人员可添加</option>
                              <option value="-1" <?php if($r['workflow_field']==-1) echo "selected";?>>mailset 特殊字段-仅邮件通知可用</option>
                            </select>
                          </div>
                    </td>
                  </tr>
                  <tr>
                    <td>
                    </td><td>
                    <div class="col-sm-4">
                        <input name="forward" type="hidden" value="<?php echo HTTP_REFERER;?>">
                        <input name="modelid" type="hidden" value="<?php echo $modelid;?>">
                      <input name="submit" type="submit" class="btn btn-info col-sm-12 col-xs-12" value="提交">
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </form>
          </div>
      </section>
</section>
<script type="text/javascript">
    $(function(){
        $(".form-horizontal").Validform({
            tiptype:2
        });
    })
    function field_select(field) {
        window.location = "index.php?m=core&f=model&v=field_add<?php echo $this->su();?>&_submenuid=<?php echo $GLOBALS['_submenuid'];?>&modelid=<?php echo $GLOBALS['modelid'];?>&formtype="+field;
    }
    function alert_warning(type,field) {
        if(type==1) {
            parent.$('#alert-warning').addClass('alert-danger');
            parent.$('#alert-warning').removeClass('hide');
            parent.$('#warning-tips').html('<strong>提示信息：</strong> 您选择在共享模型“主表”中添加字段，可能会影响性能，您确认要进行此操作吗？');

        } else {
            parent.$('#alert-warning').addClass('hide');
        }
    }
</script>
<?php include $this->template('footer','core');?>

