<?php 
    include "config/autoloader.inc.php";
    //$data = database::table('image')->select()->where("format = :format",["format"=>"adad"]);
    //echo "<pre>";
    //print_r($data);
    $args = [
        'name' => "doni.jpg",
        'format' => "png",
        'size' => 10,
    ];
    /* $array['name'] = "john2";
    $data2 = User::action()->update_by_id($array, 1);
    $data1 = User::action()->get_by_name("john1");
    $data = User::action()->get_by_id(1); */
    $data = User::action()->delete(1);
    //$data = User::action()->create($args);
    echo "<pre>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Uploader</title>
</head>
<body>
    <h1>Upload Image disini</h1>
    <form id="form" name="form">
        <input type="text" id="kategori" name="kategori">
        <input type="text" id="tag" name="tag">
        <input type="file" id="file" name="file">
        <button type="submit" id="submit" name="submit">submit</button>
    </form>
    <script src="asset/js/api.js"></script>
</body>
</html>