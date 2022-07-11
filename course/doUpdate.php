<?php
if(!isset($_POST["name"])){
    echo "沒有帶資料";
    exit;
}

require("../db-connect.php");

$id=$_POST["id"];
$name=$_POST["name"];
$url=$_POST["url"];
$description=$_POST["description"];
// echo $name;
$sql="UPDATE course SET name='$name', url='$url' WHERE id=$id";
// echo $sql;
if ($conn->query($sql) === TRUE) {
    // $message = "課程 course 修改完成";
    // echo "<script type='text/javascript'>alert('$message');
    // window.location='course.php';
    // </script>";
    
    // header("Location:course.php");
} else {
    echo "修改資料表錯誤: " . $conn->error;
}


// echo $name;
$sql="UPDATE course_content SET description='$description' WHERE id=$id";
// echo $sql;
if ($conn->query($sql) === TRUE) {
    // $message = "課程 course 修改完成";
    // echo "<script type='text/javascript'>alert('$message');
    // window.location='course.php';
    // </script>";
    
    // header("Location:course.php");
} else {
    echo "修改資料表錯誤: " . $conn->error;
}


//限制圖片型別格式，大小
if ((($_FILES["file"]["type"] == "image/gif")
        || ($_FILES["file"]["type"] == "image/jpeg")
        || ($_FILES["file"]["type"] == "image/jpg"))
    && ($_FILES["file"]["size"] < 200000)
) {
    if ($_FILES["file"]["error"] > 0) {
        echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    } else {
        // echo "檔名: " . $_FILES["file"]["name"] . "<br />";
        // echo "檔案型別: " . $_FILES["file"]["type"] . "<br />";
        // echo "檔案大小: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
        // echo "快取檔案: " . $_FILES["file"]["tmp_name"] . "<br />";


        //設定檔案上傳路徑，選擇指定資料夾
        if (file_exists("./upload/" . $_FILES["file"]["name"])) {
            echo $_FILES["file"]["name"] . " already exists. ";
        } else {
            move_uploaded_file(
                $_FILES["file"]["tmp_name"],
                "./upload/" . $_FILES["file"]["name"]
            );
            // echo "儲存於: " . "./upload/" . $_FILES["file"]["name"]; //上傳成功後提示上傳資訊
        }
    }
} else {
    // echo "上傳失敗！"; //上傳失敗後顯示錯誤資訊
}


$file = "./upload/" . $_FILES["file"]["name"];
$sqlCreate2 = "UPDATE course_content SET image='$file' WHERE id=$id";


if ($conn->query($sqlCreate2) === TRUE) {
    $message = "課程更新成功";
    echo "<script type='text/javascript'>alert('$message');
    window.location='course.php';
    </script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}




$conn->close();

?>