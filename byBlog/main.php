<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>主页</title>
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
<meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
<meta http-equiv="description" content="This is my page">
<link href="resources/css/style.css" rel="stylesheet">
</head>
<script type="text/javascript" src="resources/js/jquery-1.7.1.js"></script>
<link rel="stylesheet" type="text/css" href="resources/css/normal.css" />
<script type="text/javascript">
</script>

<style>
</style>

<body>
<article>
<header>
<object id="swftitlebar" data="resources/images/79514.swf" width="100%"
	height="70%" type="application/x-shockwave-flash"> <!-- 使用 allowscriptaccess 使 Flash 应用程序可与承载它的 HTML 页通信。
		此参数是必需的，因为 fscommand() 和 getURL() 操作可能导致 javascript 使用 HTML 页的权限，
		而该权限可能与 Flash 应用程序的权限不同。这与跨域安全性有着重要关系。always 允许随时执行脚本操作。 -->
	<param name="allowScriptAccess" value="always">
	<!--“all”:  SWF 文件中允许使用所有网络 API -->
	<param name="allownetworking" value="all">
	<!-- 启用全屏模式设置为”true”，否则设置为”false”（默认值） -->
	<param name="allowFullScreen" value="true">
	<!-- 使您可以使用 Internet Explorer 4.0 中的透明 Flash 内容、绝对定位和分层显示的功能。
		此标记/属性仅在带有 Flash Player ActiveX 控件的 Windows 中有效。 -->
	<param name="wmode" value="transparent">
	<!-- 指定当观众在浏览器中右击 (Windows) 或按住 Command 键单击 (Macintosh) 应用程序区域时将显示的菜单类型
		"true" 显示完整的菜单，让用户使用各种选项增强或控制回放。
		"false" 显示的是一个只包含"关于 Macromedia Flash Player 6"选项和"设置"选项的菜单。
		 -->
	<param name="menu" value="false">
	<!-- 当 width 和 height 值是百分比时，定义应用程序如何放置在浏览器窗口中,
		noScale 对 Flash 内容进行缩放以填充指定区域，不会发生扭曲，
		它会使应用程序保持原始高宽比，但有可能会进行一些裁剪-->
	<param name="scale" value="noScale">
	<!-- 指定缩放的 Flash SWF 文件在由 width 和 height 设置定义的区域内的位置。
		有关这些条件的详细信息，请参阅scale 属性/参数。 -->
	<param name="salign" value="1">
</object>
</header>
<div class="leftbox"><!--<div id="menu" class="vcard box">
<a class="a1" >热门微博</a><a>微话题</a> <a>找人</a><a>电影</a> <a>听歌</a><a>股票</a> <a>播客</a><a>视频</a>
</div>
-->
<div class="vcard box">
<h2>个人资料</h2>
<p class="fn">姓名：曾豪</p>
<p class="nickname">兴趣：</p>
<p class="url">职业：学生</p>
<p class="address">专业：电子信息工程</p>
<p class="role">现居：武汉市华科大</p>
</div>
<div class="blogclass box">
<ul id="blog_statistics">
	<li>原创：<span>30篇</span></li>
	<li>转载：<span>2篇</span></li>
	<li>译文：<span>4篇</span></li>
	<li>评论：<span>7条</span></li>
</ul>
</div>
</div>
<div class="centerbox box"><script type="text/javascript">
	function getArticle(){
		$.ajax({
	        type: "get",
	        dataType: "json",
	        url: 'query.php',
	        data: {
				pageNow :$(".offset").val(),
				type : 'getArticle',
	        },
	        success: function (data) {
		        if(data == ""){
					alert("已加载完毕");
					$(".isEnd").val(1);
					return ;
			    }
		        var str = "";
		        for(var i = 0; i < data.length; i ++){
		        	str += "<h2>"+data[i].releaseDate+"</h2>";
		        	str += "<h3 class=\"title\"><a href=\"query.php?type=readDetail&id="+data[i].id+"\">"+data[i].title+"</a></h3>";
	        		str += "<p>"+data[i].content+"</p>";
		        	str += "<a href=\"query.php?type=readDetail&id="+data[i].id+"\">阅读全文</a>   <div class=\"textfoot\">阅读量（"+data[i].readNum+"） 评论量( "+data[i].remarkNum+" )</div>";
			    }
		        $(".offset").val(parseInt($(".offset").val()) + 1);
		        $(".mainContent").fadeIn(str,);
	        }
		});
	}
	$(function(){
		 $(window).scroll(function () {
		        if (($(window).scrollTop()) >= ($(document).height() - $(window).height())) {
			        if($(".isEnd").val() == 0){
		        		getArticle();
				    }
		        }
		    });
		getArticle();
	});
</script> <input type="hidden" value="1" class="offset"><input type="hidden" value="0" class="isEnd">
<div class="mainContent"></div>
</div>
<div class="blank"></div>
<div class="Copyright"><a href="/">帮助中心</a> <a href="/">空间客服</a> <a
	href="/">投诉中心</a> <a href="/">空间协议</a></div>
</article>
</body>
<script type="text/javascript"></script>
</html>
