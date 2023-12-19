<?php
    require_once("connection.php");

    if(isset($_REQUEST['update_id'])){
        try{
            $id = $_REQUEST['update_id'];
            $select_stml = $db->prepare('SELECT * FROM tbl_file WHERE id = :id');
            $select_stml->bindParam(":id", $id);
            $select_stml->execute();
            $row = $select_stml->fetch(PDO::FETCH_ASSOC);
            extract($row);
            
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }

    if(isset($_REQUEST['btn_update'])){
        try{
            $name = $_REQUEST['txt_name'];

            $image_file = $_FILES['txt_file']['name'];
            $type = $_FILES['txt_file']['type'];
            $size = $_FILES['txt_file']['size'];
            $tmp = $_FILES['txt_file']['tmp_name'];

            $path = "upload/".$image_file;
            $directory = "upload/"; // set upload folder path for update time pervios file remove and new file upload 

            if($image_file){
                if($type == "image/jpg" || $type == "image/jpeg" || $type == "image/png" || $type == "image/gif"){
                    if(!file_exists($path)){// check file not exist in your upload folder path
                        if($size < 5000000){ // check file size 5MB
                            unlink($directory.$row['image']);
                            move_uploaded_file($tmp, 'upload/'.$image_file);
                        } else{
                            $errorMsh = "Your file to large please upload 5MB size";
                        } 
                    } else{
                        $errorMsh = "File already exists... Check upload folder";
                    }
                } else{
                    $errorMsh = "Uplad JPG, JPEG, PNG & GIF formats...";
                }
            } else{
                $image_file = $row['image']; // if you not select new image than previos image same
            }

            if(!isset($errorMsh)){
                $update_stmt = $db->prepare("UPDATE tbl_file SET name = :name_up, image = :file_up WHERE id = :id");
                $update_stmt->bindParam(':name_up', $name);
                $update_stmt->bindParam(':file_up', $image_file);
                $update_stmt->bindParam(':id', $id);     
            
            if($update_stmt->execute()){
                $updateMsg = "File update successfully";
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
            if(isset($updateMsg)){ ?>
                <div class="alert alert-success">
                    <strong><?php echo $updateMsg ?></strong>
                </div>
        <?php
            }
        ?>
        <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">

            <div class="form-group">
                <div class="row">
                    <label for="name" class="col-sm-3 control-label">Name</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_name" class="form-control" value="<?php echo $name; ?>">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <label for="name" class="col-sm-3 control-label">File</label>
                    <div class="col-sm-9">
                        <input type="file" name="txt_file" class="form-control" value="<?php echo $image; ?>">
                        <p>
                            <img src="upload/<?php echo $image; ?>" height="100" width="100" alt="">
                        </p>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12">
                    <input type="submit" name="btn_update" class="btn btn-primary" value="Update">
                    <a href="index.php" class="btn btn-danger">Cancel</a>
                </div>
            </div>

        </form>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>