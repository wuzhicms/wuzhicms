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
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <?php echo $this->
          menu($submenuid,'&modelid='.$GLOBALS['modelid']);?>
          <div class="panel-body" id="panel-bodys">
            <form name="myform" class="form-horizontal tasi-form" action="" method="post">
              <table class="table table-striped table-advance table-hover">
                <thead>
                  <tr>
                    <th class="tablehead">字段名称</th>
                    <th class="tablehead hidden-phone"><div class="col-sm-4">字段属性</div></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="td5">字段类型</td>
                    <td class="hidden-phone td5">
                      <div class="col-sm-4">
                        <?php echo $form->
                          select($options, $formtype, 'name="formtype" class="form-control"
                          id="formtype" onchange="field_select(this.value)"','请选择字段类型');?>
                      </div>
                    </td>
                  </tr>
                  <?php
                  if($module_config['allow_addto_master']) {
                  ?>
                  <tr>
                    <td class="td5">添加到主表</td>
                    <td class="hidden-phone td5">
                      <div class="col-sm-12">
                      <div class="row">
                        <div class="col-sm-4">
                        <label class="radio-inline">
                          <input type="radio" name="form[master_field]" value="1" onclick="alert_warning(1,'master_field')" <?php if($addto_master) echo "checked";?>>是
                        </label>
                        <label class="radio-inline">
                          <input type="radio" name="form[master_field]" value="0" <?php if($addto_master) echo "disabled";?> onclick="alert_warning(0)">否
                        </label>
                        </div>
                        <div class="col-sm-8">
                        <span class="tablewarnings"><i class="icon-info-circle"></i> 当列表中调用时，建议添加到主表</span>
                        </div>
                      </div>
                      </div>
                    </td>
                  </tr>
                  <?php } else {?>
                      <input type="hidden" name="form[master_field]" value="0">
                  <?php }?>
                  <tr>
                    <td class="td5">
                      <font color="red">*</font>
                      <strong>字段英文名</strong>
                    </td>
                    <td class="hidden-phone td5">
                      <div class="col-sm-12">
                      <div class="row">
                        <div class="col-sm-4">
                        <input type="text" name="form[field]" id="field" size="20" class="input-text form-control" datatype="/^[a-zA-Z]{1}([a-zA-Z0-9]|[_]){0,19}$/" errormsg="至少1个字符,最多30个字符！">
                        </div>
                        <div class="col-sm-8">
                        <span class="tablewarnings"><i class="icon-info-circle"></i> 只能由英文字母、数字和下划线组成，并且仅能字母开头</span>
                      </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="td5">
                      <font color="red">*</font>
                      <strong>字段别名</strong>
                    </td>
                    <td class="hidden-phone td5">
                      <div class="col-sm-4">
                        <input type="text" name="form[name]" id="name" size="30" class="input-text form-control" datatype="*1-20" errormsg="至少1个字符,最多20个字符！">
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="td5">字段提示</td>
                    <td class="hidden-phone td5">
                      <div class="col-sm-4">
                        <textarea name="form[remark]" rows="2" cols="20" id="tips" class="form-control"></textarea>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="td5">相关参数</td>
                    <td class="hidden-phone td5">
                      <div class="col-sm-12">
                        <?php if(isset($field_config[$formtype][ 'system_field'])) { include $this->
                          core_path.$formtype.'/form_setting.php'; } else { include $this->m_path.$formtype.'/form_setting.php';
                          } ?>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="td5">扩展代码</td>
                    <td class="hidden-phone td5">
                      <div class="col-sm-12">
                      <div class="row">
                        <div class="col-sm-4">
                        <input type="text" name="form[ext_code]" value="" size="50" class="input-text form-control">
                        </div>
                        <div class="col-sm-8">
                        <span class="tablewarnings"><i class="icon-info-circle"></i> 可以通过此处向表单加入任何属性</span>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="td5">字符长度取值范围</td>
                    <td class="hidden-phone td5">
                      <div class="col-sm-12">
                        <div class="row">
                          <div class="col-sm-2">最小值：
                            <input type="text" class="form-control" name="form[minlength]" id="field_minlength"
                            value="0" size="5">
                          </div>
                          <div class="col-sm-2">最大值：
                            <input type="text" class="form-control" name="form[maxlength]" id="field_maxlength"
                            value="" size="5">
                          </div>
                          <div class="col-sm-8">
                          <span class="tablewarnings"><i class="icon-info-circle"></i> 系统将在表单提交时检测数据长度范围是否符合要求，如果不想限制长度请留空</span>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="td5">数据校验正则</td>
                    <td class="hidden-phone td5">
                      <div class="col-sm-12">
                        <div class="row">
                          <div class="col-sm-2">
                            <input type="text" name="form[pattern]" id="pattern" value="" size="40"
                            class="input-text form-control">
                          </div>
                          <div class="col-sm-2">
                            <select name="pattern_select" onchange="javascript:$('#pattern').val(this.value)"
                            class="form-control m-bot15 col-sm-2 ">
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
                          <div class="col-sm-8">
                          <span class="tablewarnings"><i class="icon-info-circle"></i> 系统将通过此正则校验表单提交的数据合法性，如果不想校验数据请留空</span>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="td5">数据校验未通过的提示信息</td>
                    <td class="hidden-phone td5">
                      <div class="col-sm-4">
                        <input type="text" name="form[errortips]" value="" size="50" class="input-text form-control">
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="td5">在表单哪个位置显示</td>
                    <td class="hidden-phone td5">
                        <div class="col-sm-8">
                            <label class="radio-inline">
                                <input type="radio" name="form[location]" value="0" checked>基本信息
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="form[location]" value="1" >高级设置
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="form[location]" value="2" >权限与收费
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="form[location]" value="5" >手动表单项
                            </label>
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="td5">作为搜索条件</td>
                    <td class="hidden-phone td5">
                      <div class="col-sm-4">
                          <label class="radio-inline">
                        <input type="radio" name="form[search_field]" value="1" id="field_allow_search1">是
                              </label>
                          <label class="radio-inline">
                        <input type="radio" name="form[search_field]" value="0" id="field_allow_search0"
                        checked>否</label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="td5">在前台投稿中显示</td>
                    <td class="hidden-phone td5">
                      <div class="col-sm-4">
                          <label class="radio-inline">
                        <input type="radio" name="form[ban_contribute]" value="1" checked />是</label>
                          <label class="radio-inline">
                        <input type="radio" name="form[ban_contribute]" value="0" />否</label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="td5">作为全站搜索信息</td>
                    <td class="hidden-phone td5">
                      <div class="col-sm-4">
                          <label class="radio-inline">
                        <input type="radio" name="form[to_fulltext]" value="1" id="field_allow_fulltext1"
                        checked/>是</label>
                          <label class="radio-inline">
                        <input type="radio" name="form[to_fulltext]" value="0" id="field_allow_fulltext0"
                        />否</label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="td5">作为超级字段的附属字段</td>
                    <td class="hidden-phone td5">
                      <div class="col-sm-12">
                      <div class="row">
                        <div class="col-sm-2">
                            <label class="radio-inline">
                        <input type="radio" name="form[powerful_field]" value="1" />是</label>
                            <label class="radio-inline">
                        <input type="radio" name="form[powerful_field]" value="0" checked/>否
                                </label>
                        </div>
                        <div class="col-sm-10">
                        <span class="tablewarnings"><i class="icon-info-circle"></i> 必须与超级字段结合起来使用，否则内容添加的时候不会正常显示</span>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="td5">添加到碎片</td>
                    <td class="hidden-phone td5">
                      <div class="col-sm-4">
                          <label class="radio-inline">
                        <input type="radio" name="form[to_block]" value="1" />是</label>
                          <label class="radio-inline">
                        <input type="radio" name="form[to_block]" value="0" checked/>否</label>
                      </div>
                    </td>
                  </tr>

                  <tr>
                    <td class="td5">后台不显示该字段</td>
                    <td class="hidden-phone td5">
                      <div class="col-sm-12">
                      <label class="checkbox-inline ib"><input type="checkbox" id="unsetroleids[]" id="_1" value="1"> 超级管理员</label>
                      <label class="checkbox-inline ib"><input type="checkbox" id="unsetroleids[]" id="_2" value="2"> 站点管理员</label>
                      <label class="checkbox-inline ib"><input type="checkbox" id="unsetroleids[]" id="_3" value="3"> 运营总监</label>
                      <label class="checkbox-inline ib"><input type="checkbox" id="unsetroleids[]" id="_4" value="4"> 总编</label>
                      <label class="checkbox-inline ib"><input type="checkbox" id="unsetroleids[]" id="_5" value="5"> 编辑</label>
                      <label class="checkbox-inline ib"><input type="checkbox" id="unsetroleids[]" id="_6" value="6"> 发布人员</label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="td5">
                      
                    </td>
                    <td class="td5">
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
    </div>
  </div>
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
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

