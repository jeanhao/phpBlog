    function init() {
        panel1 = document.getElementById('panel1');
        panel2 = document.getElementById('panel2');
        label1 = document.getElementById('label1');
        label2 = document.getElementById('label2');
        $.ajax({
            type: 'get',
            data: {
                pageCount: 'true'
            },
            url: 'checkUser.php',
            success: function(data) {
                var pageNumArray = data.split(",");
                $(".allPageNum1").html(pageNumArray[1]);
                $(".allPageNum2").html(pageNumArray[0]);
            }
        });
        getUser(1, {
            pageNow: $(".pageNow1").html(),
            isValid: 'true'
        });
    }

function checkUser() {
    label2.style.backgroundColor = "transparent";
    label2.style.color = "white";
    label1.style.backgroundColor = "#fff";
    label1.style.color = 'grey';
    panel1.style.display = 'block';
    panel2.style.display = 'none';
    getUser(1, {
        pageNow: $(".pageNow1").html(),
        isValid: 'true'
    });
}

function viewUser() {
    label2.style.backgroundColor = "#fff";
    label2.style.color = 'grey';
    label1.style.backgroundColor = "transparent";
    label1.style.color = 'white';
    panel1.style.display = 'none';
    panel2.style.display = 'block';
    getUser(2, {
        pageNow: $(".pageNow2").html()
    });
}

function getUser(n, data) {
    var Jobject = $(".content" + n);
    $.ajax({
        type: 'get',
        data: data,
        url: 'checkUser.php',
        dataType: 'html',
        success: function(rdata) {
            Jobject.html(rdata);
        }
    });
}

function enable(id) {
    $.ajax({
        url: 'checkUser.php',
        type: 'get',
        data: {
            id: id,
            type: 'enable'
        },
        success: function() {
            alert("邮件通知该用户授权通过，同时激活用户。");
            getUser(1, {
                pageNow: $(".pageNow1").html(),
                isValid: 'true'
            });
        }
    });
}

function disable(id) {
    $.ajax({
        url: 'checkUser.php',
        type: 'get',
        data: {
            id: id,
            type: 'disable'
        },
        success: function() {
            alert("邮件通知该用户授权未通过，同时删除相关用户信息。");
            getUser(1, {
                pageNow: $(".pageNow1").html(),
                isValid: 'true',
            });
        }
    });
}

function modify(id) {
    $.ajax({
        url: 'checkUser.php',
        type: 'get',
        data: {
            id: id,
            type: 'modify',
            data: $(".userName" + id).val()
        },
        success: function() {
            alert("修改成功!");
            getUser(2, {
                pageNow: $(".pageNow2").html()
            });
        }
    });
}

function toModify(id) {
    var mUserName = $(".muserName" + id);
    var inputStr = '<input type="text" value="' + mUserName.html() + '" class="userName' + id + ' " >';
    mUserName.html(inputStr);
    modifyButton = $(".mbutton" + id);
    modifyButton.html("<button  style=\"width:100px\"class=\"button purple modify" + id + "\"onclick=\"modify(" + id + ")\" >确定修改</button>")
}

function deleteU(id) {
    $.ajax({
        url: 'checkUser.php',
        type: 'get',
        data: {
            id: id,
            type: 'delete'
        },
        success: function() {
            alert("删除成功！");
            getUser(2, {
                pageNow: $(".pageNow2").html()
            });
        }
    });
}

function changePage(n, offset) {
    var pageNow = parseInt($(".pageNow" + n).html());
    if (offset == -1 && pageNow <= 1) {
        alert("已到首页");
    } else if (offset == 1 && pageNow >= $(".allPageNum" + n).html()) {
        alert("已到尾页");
    } else {
        var data;
        if (n == 1) {
            data = {
                pageNow: (pageNow + offset),
                isValid: "true"
            }
        } else {
            data = {
                pageNow: (pageNow + offset)
            }
        }
        getUser(n, data);
        $(".pageNow" + n).html(pageNow + offset);
    }

}
