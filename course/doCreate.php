<?php

require('../db-connect.php');
if (!isset($_POST["name"])) {
    echo "沒有帶資料到本頁";
    exit;
}

$name = $_POST["name"];
$description = $_POST["description"];
$url = $_POST["url"];
// $create_time=date('Y-m-d H:i:s');
// echo $now;

// echo "$name,$email,$phone";
// exit;


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
    echo "上傳失敗！"; //上傳失敗後顯示錯誤資訊
}




//寫入資料庫
$now = date('Y-m-d H:i:s');
$sqlCreate = "INSERT INTO course (name,create_time,url) VALUES ('$name','$now','$url')";

if ($conn->query($sqlCreate) === TRUE) {
    // $message = "新課程輸入成功1";
    // echo "<script type='text/javascript'>alert('$message');
    // // window.location='course.php';
    // </script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$file = "./upload/" . $_FILES["file"]["name"];

$sqlCreate2 = "INSERT INTO course_content (description,image) VALUES ('$description','$file')";
if ($conn->query($sqlCreate2) === TRUE) {
    $message = "課程新增成功";
    echo "<script type='text/javascript'>alert('$message');
    window.location='course.php';
    </script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>