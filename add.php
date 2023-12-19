<?php
        require_once('connection.php');
        if (isset($_REQUEST['btn_insert'])){
            try{
                $name = $_REQUEST['txt_name'];

                $image_file = $_FILES['txt_file']['name'];
                $type = $_FILES['txt_file']['type'];
                $size = $_FILES['txt_file']['size'];
                $temp = $_FILES['txt_file']['tmp_name'];

                $path = "uploads/".$image_file; //set upload path

                if (empty($name)){ 
                    $errorMsh = "Please enter name";
                } else if(empty($image_file)){
                    $errorMsh = "Please select image";
                } else if($type == "image/jpg" || $type == "image/jpeg" || $type == "image/png" || $type == "image/gif"){
                    if(!file_exists($path)){ // check file not exist in your upload folder path
                        if($size < 5000000){
                            move_uploaded_file($temp, 'upload/' .$image_file);
                        } else{
                            $errorMsh = "Your file too large please upload 5MB size";
                        }
                    }else{
                        $errorMsh = "File alredy exists... Check upload floder";
                    }
                } else{
                    $errorMsh = "Upload JPG, JPEG, PNG & GIF file formate....";
                }

                if(!isset($errorMsh)){
                    $insert_stmt = $db->prepare("INSERT INTO tbl_file(name, image) VALUE (:fname, :fimage)");
                    $insert_stmt->bindParam(":fname", $name);
                    $insert_stmt->bindParam(":fimage", $image_file);

                    if($insert_stmt->execute()){
                        $insertMsg = "File Uploaded successfully...";
                        header("refresh:2;index.php");
                    }
                }
            


            } catch(PDOException $e) {
                    $e->getMessage();
            }
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    
    <div class="container text-center">
        <h1>Insert file page</h1>
        <?php
            if(isset($errorMsh)){ ?>
                <div class="alert alert-danger">
                    <strong><?php echo $errorMsh ?></strong>
                </div>
        <?php
            }
        ?>
        <?php
            if(isset($insertMsg)){ ?>
                <div class="alert alert-success">
                    <strong><?php echo $insertMsg ?></strong>
                </div>
        <?php
            }
        ?>
        <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">

            <div class="form-group">
                <div class="row">
                    <label for="name" class="col-sm-3 control-label">Name</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_name" class="form-control" placeholder="Enter name">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <label for="name" class="col-sm-3 control-label">File</label>
                    <div class="col-sm-9">
                        <input type="file" name="txt_file" class="form-control">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12">
                    <input type="submit" name="btn_insert" class="btn btn-success" value="Insert">
                    <a href="index.php" class="btn btn-danger">Cancel</a>
                </div>
            </div>

        </form>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>