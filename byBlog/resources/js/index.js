function getArticle() {
    $.ajax({
        type: "get",
        dataType: "json",
        url: 'query.php',
        data: {
            pageNow: $(".offset").val(),
            type: 'getArticle',
        },
        success: function(data) {
            if (data == "") {
                alert("已加载完毕");
                $(".isEnd").val(1);
                return;
            }
            var str = "";
            for (var i = 0; i < data.length; i++) {
                str += "<h2>" + data[i].releaseDate + "</h2>";
                str += "<h3 class=\"title\"><a href=\"query.php?type=readDetail&id=" + data[i].id + "\">" + data[i].title + "</a></h3>";
                if (data[i].content.length > 300) {
                    str += "<p>" + data[i].content.substring(0, 300) + "......</p>";
                } else {
                    str += "<p>" + data[i].content + "</p>";
                }
                str += " <div class=\"textfoot\"><a href=\"query.php?type=readDetail&id=" + data[i].id + "\">阅读全文</a>  阅读量（" + data[i].readNum + "） 评论量( " + data[i].remarkNum + " )</div>";
            }
            $(".offset").val(parseInt($(".offset").val()) + 1);
            $(".mainContent").append(str);
        }
    });
}

$(function() {
    $(window).scroll(function() {
        if (($(window).scrollTop()) >= ($(document).height() - $(window).height())) {
            if ($(".isEnd").val() == 0) {
                getArticle();
            }
        }
    });
    getArticle();
});
