<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * url路径生成
 */
class WUZHI_url {
    public $category;//当前栏目配置信息
    public $categorys;//当前模块所有栏目
	public function __construct($category = '') {
        $this->category = $category;
		$this->siteid = get_cookie('siteid');
		if(!$this->siteid) $this->siteid = 1;
		$this->sitelist = get_cache('sitelist');
	}
    public function set_category($category) {
        $this->category = $category;
    }
    public function set_categorys($categorys) {
        $this->categorys = $categorys;
    }
    public function listurl($configs) {
        if(empty($configs['cid'])) return 'configs error';
        $page = intval($configs['page']);
        $page = max(1,$page);
        $urlrule = $this->category['listurl'];
        $urlrules = explode('|',$urlrule);
        if($page==1) {
            $urlrule = $urlrules[0];
        } else {
            $urlrule = $urlrules[1];
        }
        if($this->category['pid']) {
            $configs['categorydir'] = $this->category['parentdir'];
        } else {
            $configs['categorydir'] = '';
        }

        $configs['catdir'] = $this->category['catdir'];
        preg_match_all('/{\$([a-z0-9_]+)}/',$urlrule,$_match);
        $replace = array();
        foreach($_match[1] as $_mat) {
            $replace[] = $$_mat = isset($configs[$_mat]) ? $configs[$_mat] : output($GLOBALS,$_mat);
        }
        $url = str_replace($_match[0],$replace,$urlrule);
        $urls = '';
		$siteid = $this->siteid;
        if($this->category['listhtml']) {//生成静态
            $domain = $this->get_domain($configs['cid']);
            if($domain) {
                if($this->category['domain']) {//一级栏目绑定域名
                    $urls['url'] = $domain['url'];
                    $urls['root'] = $domain['root'];
                } else {
                    $urls['url'] = $domain['url'].$configs['catdir'].'/';
                    $urls['root'] = $domain['root'].$configs['catdir'].'/';
                }
                if($page==1) {
					$urls['root'] = $urls['root'].'index'.POSTFIX;
                } else {
					$urls['root'] = $urls['root'].$page.POSTFIX;
				}
            } else {
                $url = str_replace('//','/',$url);
                $url = ltrim($url,'/');
				if(ENABLE_SITES) {//开启站群
					$urls['url'] = $this->sitelist[$siteid]['url'].$url;
					if($this->sitelist[$siteid]['html_root']=='') {
						$this->sitelist[$siteid]['html_root'] = WWW_ROOT;
					}
					$urls['root'] = $this->sitelist[$siteid]['html_root'].$url;
				} else {//未开启站群
					$urls['url'] = WWW_PATH.$url;
					$urls['root'] = WWW_ROOT.ltrim(WWW_PATH,'/').$url;
				}

                if($page==1) {
                    $pos = strrpos($urls['url'],'/')+1;
                    $urls['url'] = substr($urls['url'],0,$pos);
                }
            }
        } else {//动态地址
            $urls['url'] = WWW_PATH.$url;
        }
        return $urls;
    }
    private function get_domain($cid) {
        if($this->category['domain']) {
            $urls['url'] = $this->category['domain'];
            $urls['root'] = WWW_ROOT.$this->category['catdir'].'/';
        } elseif($this->category['pid']) {//有父栏目
            $parents = $this->get_parents($cid);
            $parents = explode(',',$parents);
            $maxid = count($parents);
            if(!isset($this->categorys[$parents[1]]['domain'])) {
                return '';
            }

			//krsort($parents);

            $urls['url'] = $this->categorys[$parents[1]]['domain'];
            $urls['root'] = WWW_ROOT.$this->categorys[$parents[1]]['catdir'].'/';
            foreach($parents as $_key=>$_v) {
                if($_key==$maxid || $_v==0) continue;
				if(strpos($this->categorys[$parents[$_key]]['domain'],'://')!==false) {
					continue;
				}
                $urls['url'] .= $this->categorys[$_v]['catdir'].'/';
                $urls['root'] .= $this->categorys[$_v]['catdir'].'/';
            }
        } else {
            $urls = '';
        }

        return $urls;
    }
    private function get_parents($cid, $arrpid = '', $n = 1) {
        if($n > 5 || !is_array($this->categorys) || !isset($this->categorys[$cid])) return false;
        $pid = $this->categorys[$cid]['pid'];
        $arrpid = $arrpid ? $pid.','.$arrpid : $pid;
        if($pid) {
            $arrpid = $this->get_parents($pid, $arrpid, ++$n);
        } else {
            $this->categorys[$cid]['arrpid'] = $arrpid;
        }
        $parentid = $this->categorys[$cid]['pid'];
        return $arrpid;
    }
    /**
     * 内容页面链接地址生成，规则中的变量，除了默认的一些之外还可以自定义。
     * @param $configs
     * @return mixed|string
     */
    public function showurl($configs) {
        if(empty($configs['id']) || empty($configs['cid']) || empty($configs['addtime'])) return 'configs error';
		$siteid = $this->siteid;
        $page = intval($configs['page']);
        $page = max(1,$page);
        
        $urlrule = $this->category['showurl'];
        $urlrules = explode('|',$urlrule);
        if($page==1) {
            $urlrule = $urlrules[0];
        } else {
            $urlrule = $urlrules[1];
        }
        if($configs['route']==1 && $this->category['showhtml']) $configs['id'] = $this->encodeid($configs['id']);
        $configs['categorydir'] = $this->category['parentdir'];
        $configs['catdir'] = $this->category['catdir'];
        $configs['year'] = date('Y',$configs['addtime']);
        $configs['month'] = date('m',$configs['addtime']);
        $configs['day'] = date('d',$configs['addtime']);
        //$urlrule = '{$year}/{$cid}/{$id}.html|{$year}/{$cid}/{$id}-{$page}.html';
        preg_match_all('/{\$([a-z0-9_]+)}/',$urlrule,$_match);
        $replace = array();
        foreach($_match[1] as $_mat) {
            $replace[] = $$_mat = isset($configs[$_mat]) ? $configs[$_mat] : output($GLOBALS,$_mat);
        }
        $url = str_replace($_match[0],$replace,$urlrule);
        $urls = '';
        if($this->category['showhtml']) {//生成静态
            $domain = $this->get_domain($configs['cid']);
            if($domain) {
                $urls['url'] = $domain['url'].$url;
                $urls['root'] = $domain['root'].$url;
            } else {
                $url = str_replace('//','/',$url);
                $url = ltrim($url,'/');
				if(ENABLE_SITES) {//开启站群
					$urls['url'] = $this->sitelist[$siteid]['url'].$url;
					if($this->sitelist[$siteid]['html_root']=='') {
						$this->sitelist[$siteid]['html_root'] = WWW_ROOT;
					}
					$urls['root'] = $this->sitelist[$siteid]['html_root'].$url;
				} else {//未开启站群
					$urls['url'] = WWW_PATH.$url;
					$urls['root'] = WWW_ROOT.ltrim(WWW_PATH,'/').$url;
				}
            }
        } else {//动态地址
            $urls['url'] = $this->sitelist[$siteid]['url'].$url;
        }
        //print_r($urls);
        return $urls;
	}
    private function encodeid($str) {
        $str = str_pad($str, 10, 1, STR_PAD_LEFT);
        $str = base64_encode($str);
        $str = substr($str,0,-2);
        return strtoupper($str);
    }
}