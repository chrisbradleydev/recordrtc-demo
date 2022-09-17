<?php
header('Access-Control-Allow-Origin: https://frontend.demo.test');
foreach (array('video', 'audio') as $type) {
    if (isset($_FILES["${type}-blob"])) {
        $fileName = $_POST["${type}-filename"];
        if (!move_uploaded_file($_FILES["${type}-blob"]["tmp_name"], $fileName)) {
            echo "problem moving uploaded file";
        }
    }
}
