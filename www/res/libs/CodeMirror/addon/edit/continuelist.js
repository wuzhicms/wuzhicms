'use strict';(function(f){"object"==typeof exports&&"object"==typeof module?f(require("../../lib/codemirror")):"function"==typeof define&&define.amd?define(["../../lib/codemirror"],f):f(CodeMirror)})(function(f){var n=/^(\s*)(>[> ]*|[*+-] \[[x ]\]\s|[*+-]\s|(\d+)([.)]))(\s*)/,x=/^(\s*)(>[> ]*|[*+-] \[[x ]\]|[*+-]|(\d+)[.)])(\s*)$/,y=/[*+-]\s/;f.commands.newlineAndIndentContinueMarkdownList=function(b){if(b.getOption("disableInput"))return f.Pass;for(var q=b.listSelections(),r=[],g=0;g<q.length;g++){var c=
q[g].head,a=b.getStateAfter(c.line);a=f.innerMode(b.getMode(),a);if("markdown"!==a.mode.name){b.execCommand("newlineAndIndent");return}a=a.state;var e=!1!==a.list,h=0!==a.quote,d=b.getLine(c.line);a=n.exec(d);var l=/^\s*$/.test(d.slice(0,c.ch));if(!q[g].empty()||!e&&!h||!a||l){b.execCommand("newlineAndIndent");return}if(x.test(d))/>\s*$/.test(d)||b.replaceRange("",{line:c.line,ch:0},{line:c.line,ch:c.ch+1}),r[g]="\n";else if(e=a[1],h=a[5],a=(d=!(y.test(a[2])||0<=a[2].indexOf(">")))?parseInt(a[3],
10)+1+a[4]:a[2].replace("x"," "),r[g]="\n"+e+a+h,d)a:{a=b;c=c.line;h=e=0;d=n.exec(a.getLine(c));l=d[1];do{e+=1;var t=c+e,u=a.getLine(t),k=n.exec(u);if(k){var p=k[1],v=parseInt(d[3],10)+e-h,m=parseInt(k[3],10),w=m;if(l!==p||isNaN(m)){if(l.length>p.length)break a;if(l.length<p.length&&1===e)break a;h+=1}else v===m&&(w=m+1),v>m&&(w=v+1),a.replaceRange(u.replace(n,p+w+k[4]+k[5]),{line:t,ch:0},{line:t,ch:u.length})}}while(k)}}b.replaceSelections(r)}});