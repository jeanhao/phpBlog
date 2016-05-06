function init() {
    panel1 = document.getElementById('panel1');
    panel2 = document.getElementById('panel2');
    label1 = document.getElementById('label1');
    label2 = document.getElementById('label2');
}

function showLogin() {
    label2.style.backgroundColor = "transparent";
    label2.style.color = "white";
    label1.style.backgroundColor = "#fff";
    label1.style.color = 'grey';
    panel1.style.display = 'block';
    panel2.style.display = 'none';
}

function showRegister() {
    label2.style.backgroundColor = "#fff";
    label2.style.color = 'grey';
    label1.style.backgroundColor = "transparent";
    label1.style.color = 'white';
    panel1.style.display = 'none';
    panel2.style.display = 'block';
}

function register(){
    var regForm = document.getElementById('myform2');
    var userName = regForm[0].value;
    var password = regForm[1].value;
    var email = regForm[2].value;

    var reg1 = /^\w{5,20}$/;
    if(!reg1.test(userName)){
         alert("用户名格式不正确，必须为5-20个大小写字母/数字或下划线");
         return ;
    }
    var reg2 = /^[a-zA-Z]\w{4,19}$/;
    if(!reg2.test(password)){
        alert("密码格式不正确，必须以字母开头，长度在6~18之间，只能包含字符、数字和下划线");
        return ;
    }
    var reg3 =  /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
    if(!reg3.test(email)){
        alert("邮箱格式不正确");
        return ;
    }
    regForm.submit();
}