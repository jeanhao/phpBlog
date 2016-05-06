<?php
function fileext($filename){
    return substr(strrchr($filename, '.'), 1);
}
//生成随机文件名函数
function random($length,$prefix){
    $prefix .= '_';
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
    $max = strlen($chars) - 1;
    mt_srand((double)microtime() * 1000000);
    for($i = 0; $i < $length; $i++)
    {
        $prefix .= $chars[mt_rand(0, $max)];
    }
    return $prefix;
}
/**
 * return ,1:上传失败，2:文件类型有误,正常返回：文件名;3:无上传文件
 * type允许上传的文件类型
 * prefix文件前缀名
 */
function upload($type,$prefix){
    header('Content-Type:text/html;charset=utf-8');
    $uploaddir = "/home/zenghao/website/uploadfile/";//设置文件保存目录 注意包含/
    $file = $_FILES[$prefix];
    if($file['name'] != ""){
        //获取文件后缀名函数
        $fileType=strtolower(fileext($file['name']));
        //判断文件类型
        if(!in_array($fileType,$type)){
            $text=implode(",",$type);
            return 2;
        }else{//生成目标文件的文件名
            $filename=explode(".",$file['name']);
            do{
                $filename[0]=random(10,$prefix); //设置随机数长度
                $name=implode(".",$filename);
                $uploadfile=$uploaddir.$name;
            }
            while(file_exists($uploadfile));
            if (move_uploaded_file($file['tmp_name'],$uploadfile)){
                return $name;
            }else {
                return 1;
            }
        }
    }else{
        return 3;
    }

}
?>