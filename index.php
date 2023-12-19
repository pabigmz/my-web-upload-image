<?php
    require_once("connection.php");

    if(isset($_REQUEST['delete_id'])){
        $id = $_REQUEST['delete_id'];

        $select_stml = $db->prepare('SELECT * FROM tbl_file WHERE id = :id');
        $select_stml->bindParam(':id', $id);
        $select_stml->execute();
        $row = $select_stml->fetch(PDO::FETCH_ASSOC);
        unlink("upload/".$row['image']); // unlink function permanently your file

        // delete an original record from db
        $delete_stmt = $db->prepare('DELETE FROM tbl_file WHERE id = :id');
        $delete_stmt->bindParam(':id',  $id);
        $delete_stmt->execute();

        header('Location: index.php');

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
        <h1>Inder Page</h1>

        <a href="add.php" class="btn btn-success">Add Image</a>

        <table class="table table-striped table-bordered table-hober">
            <thead>
                <tr>
                    <td>Name</td>
                    <td>Image</td>
                    <td>Edit</td>
                    <td>Delete</td>
                </tr>
            </thead>

            <tbody>
                <?php
                    $select_stml = $db->prepare("SELECT * FROM tbl_file");
                    $select_stml->execute();

                    while($row = $select_stml->fetch(PDO::FETCH_ASSOC)){
                ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><img src="upload/<?php echo $row['image']; ?>" width="100px" height="100px" alt=""></td>
                        <td><a href="edit.php?update_id=<?php echo $row["id"]; ?>" class="btn btn-warning">Edit</a></td>
                        <td><a href="?delete_id=<?php echo $row["id"]; ?>" class="btn btn-danger">Delete</a></td>
                    </tr>

                <?php } ?>
            </tbody>
        </table>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>