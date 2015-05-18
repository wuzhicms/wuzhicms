<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 英文字符处理字符处理，完整的单词处理
 */
function word_limit($str, $limit = 100, $end_char = '&#8230;') {
	if (trim($str) === ''){
		return $str;
	}
	preg_match('/^\s*+(?:\S++\s*+){1,'.(int) $limit.'}/', $str, $matches);
	if (strlen($str) === strlen($matches[0])){
		$end_char = '';
	}
	return rtrim($matches[0]).$end_char;
}
/**
 * 英文字符处理，完整的单词处理
 */
function character_limiter($str, $n = 500, $end_char = '&#8230;') {
	if (mb_strlen($str) < $n) {
		return $str;
	}
	// a bit complicated, but faster than preg_replace with \s+
	$str = preg_replace('/ {2,}/', ' ', str_replace(array("\r", "\n", "\t", "\x0B", "\x0C"), ' ', $str));
	if (mb_strlen($str) <= $n){
		return $str;
	}
	$out = '';
	foreach (explode(' ', trim($str)) as $val){
		$out .= $val.' ';
		if (mb_strlen($out) >= $n) {
			$out = trim($out);
			return (mb_strlen($out) === mb_strlen($str)) ? $out : $out.$end_char;
		}
	}
}

/**
	 * Code Highlighter
	 *
	 * Colorizes code strings
	 *
	 * @param	string	the text string
	 * @return	string
	 */
	function highlight_code($str)
	{
		/* The highlight string function encodes and highlights
		 * brackets so we need them to start raw.
		 *
		 * Also replace any existing PHP tags to temporary markers
		 * so they don't accidentally break the string out of PHP,
		 * and thus, thwart the highlighting.
		 */
		$str = str_replace(
			array('&lt;', '&gt;', '<?', '?>', '<%', '%>', '\\', '</script>'),
			array('<', '>', 'phptagopen', 'phptagclose', 'asptagopen', 'asptagclose', 'backslashtmp', 'scriptclose'),
			$str
		);

		// The highlight_string function requires that the text be surrounded
		// by PHP tags, which we will remove later
		$str = highlight_string('<?php '.$str.' ?>', TRUE);

		// Remove our artificially added PHP, and the syntax highlighting that came with it
		$str = preg_replace(
			array(
				'/<span style="color: #([A-Z0-9]+)">&lt;\?php(&nbsp;| )/i',
				'/(<span style="color: #[A-Z0-9]+">.*?)\?&gt;<\/span>\n<\/span>\n<\/code>/is',
				'/<span style="color: #[A-Z0-9]+"\><\/span>/i'
			),
			array(
				'<span style="color: #$1">',
				"$1</span>\n</span>\n</code>",
				''
			),
			$str
		);

		// Replace our markers back to PHP tags.
		return str_replace(
			array('phptagopen', 'phptagclose', 'asptagopen', 'asptagclose', 'backslashtmp', 'scriptclose'),
			array('&lt;?', '?&gt;', '&lt;%', '%&gt;', '\\', '&lt;/script&gt;'),
			$str
		);
	}

/**
 * @param $str 将字符编码
 * @return string
 */
function escape($str) {
    preg_match_all("/[\x80-\xff].|[\x01-\x7f]+/", $str, $r);
    $ar = $r[0];
    foreach ($ar as $k => $v) {
        if (ord($v[0]) < 128) $ar[$k] = rawurlencode($v);
        else
            $ar[$k] = "%u" . bin2hex(iconv(CHARSET, "UCS-2", $v));
    }
    return join("", $ar);
}