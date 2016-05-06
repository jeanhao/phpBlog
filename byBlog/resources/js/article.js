  function playPause() {
      if ($("#video1")[0].paused)
          $("#video1")[0].play();
      else
          $("#video1")[0].pause();
  }

  function makeBig() {
      $("#video1")[0].width = 560;
  }

  function makeSmall() {
      $("#video1")[0].width = 320;
  }

  function makeNormal() {
      $("#video1")[0].width = 420;
  }

  function getComment(articleId,pageNow) {
      $.ajax({
          type: "get",
          dataType: "json",
          url: 'query.php',
          data: {
              type: 'showRemark',
              articleId: articleId,
              pageNow: pageNow
          },
          success: function(data) {
              if (data != "") {
                  var str = "";
                  for (var i = 0; i < data.length; i++) {
                      str += "<div><p>评论者：" + data[i].remarker + " <br>评论内容:" + data[i].comments + "</p><div><div class=\"textfoot\">评论时间：" + data[i].remarkTime + "</div>";
                  }
                  $(".showComment").html(str);
              }
          },
          fail: function() {
              alert("失败了");
          }
      });
  }

  function changePage(offset) { //0首页，-1上一页，1下一页，2尾页
      var pageNow = $(".pageNow").html();
      var allPageNum = $(".allPageNum").html();
      if (offset == 0) {
          if (pageNow == 1) {
              alert("已在首页");
          } else {
              $(".pageNow").html(1);
              getComment(1);
          }
      } else if (offset == 1) {
          if (pageNow == allPageNum) {
              alert("已在最后一页");
          } else {
              $(".pageNow").html(parseInt(pageNow) + 1);
              getComment(parseInt(pageNow) + 1);
          }
      } else if (offset == -1) {
          if (pageNow == 1) {
              alert("已在第一页");
          } else {
              $(".pageNow").html(parseInt(pageNow) - 1);
              getComment(parseInt(pageNow) - 1);
          }
      } else {
          if (pageNow == allPageNum) {
              alert("已在尾页");
          } else {
              $(".pageNow").html(allPageNum);
              getComment(allPageNum);
          }
      }
  }
