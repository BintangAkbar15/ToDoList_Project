<?php 
require('Connection.php');
?>

<?php  

if(isset($_GET['Done'])){
    $task_id = $_GET['Done'];

    $query = mysqli_query($koneksi, "UPDATE tasks SET t_status = 'Done' WHERE t_id='$task_id'");
    header("Location: index.php");
}
if(isset($_GET['drop'])){
    $status = $_GET['drop'];
    if($status == "ALL-PENDING"){
        $query = mysqli_query($koneksi, "DELETE FROM tasks WHERE t_status = 'Pending'");
        header("Location: index.php");
    }elseif($status == "ALL-DONE"){
        $query = mysqli_query($koneksi, "DELETE FROM tasks WHERE t_status = 'Done'");
        header("Location: index.php");
    }else{
        header("Location: index.php");
    }
}

if(isset($_GET['edit'])){
    $task_id = $_GET['edit'];
    if(isset($_POST['add_post'])){
        $taskname = mysqli_real_escape_string($koneksi, $_POST['task_name']);
        $query = mysqli_query($koneksi, "UPDATE tasks SET t_name = '$taskname' WHERE t_id='$task_id'");
        header("Location: index.php");
    }
}else{
    if(isset($_POST['add_post'])){
        $taskname = mysqli_real_escape_string($koneksi, $_POST['task_name']);
        $query = mysqli_query($koneksi, "INSERT INTO tasks(t_name,t_status,t_date) VALUES ('$taskname', 'Pending', now())");
        header("Location: index.php");
    }
}

if(isset($_GET['delete'])){
    $task_id = $_GET['delete'];

    $query = mysqli_query($koneksi, "DELETE FROM tasks WHERE t_id ='$task_id'");
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDoList-APP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="container my-5">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">TODOLIST-APP</h1>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-6 mb-4">
            <div class="card shadow-lg border-0">
                <div class="card-body">
                    <h3>Form Add New Task</h3>
                    <form method="post" class="mb-3">
                        <div class="form-group mb-3">
                            <input type="text" class="form-control" name="task_name" placeholder="Input Nama Tugas" value='<?php if(isset($_GET['edit'])){ 
                                $query = mysqli_query($koneksi, "SELECT * FROM tasks WHERE t_status = 'Pending'");                                $row = mysqli_fetch_array($query);
                                echo $row['t_name'];}?>' required>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="add_post" class="btn btn-primary w-100">Tambah Tugas</button>
                        </div>
                    </form>
                    <h3>List Task Pending</h3>
                    <ul class="list-group">
                        <?php $query = mysqli_query($koneksi, "SELECT * FROM tasks WHERE t_status = 'Pending'");
                        
                        while($row = mysqli_fetch_array($query)) :
                            $task_name = $row['t_name'];
                        ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo $task_name;?>
                                <div>
                                    <a href="index.php?Done=<?php echo $row['t_id']?>" class="btn btn-success me-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                            <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
                                        </svg>
                                    </a>
                                    <a href="index.php?edit=<?php echo $row['t_id']?>" class="btn btn-warning me-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                                        </svg>
                                    </a>
                                    <a href="index.php?delete=<?php echo $row['t_id']?>" class="btn btn-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                        </svg>
                                    </a>
                                </div>
                            </li>
                        <?php endwhile; ?>
                        <?php
                        $query = mysqli_query($koneksi, "SELECT * FROM tasks WHERE t_status = 'Pending'");
                        if($row = mysqli_fetch_array($query) > 0) :
                        ?>
                        <li class="d-flex justify-content-between align-items-center mt-4">
                            <a href="index.php?drop=ALL-PENDING" class="btn btn-danger">
                                DELETE ALL
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.8824zM2.5 3h11V2h-11z"/>
                                </svg>
                            </a>
                        </li>
                        <?php endif;?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-body">
                    <h3>List Done Task</h3>
                    <ul class="list-group">
                    <?php $query = mysqli_query($koneksi, "SELECT * FROM tasks WHERE t_status = 'Done'");
                        
                        while($row = mysqli_fetch_array($query)) :
                            $task_name = $row['t_name'];
                        ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo $task_name?>
                            <div class="float-right">
                                <span class="badge bg-success">Done</span>
                                <a href="index.php?delete=<?php echo $row['t_id']?>" class="btn btn-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                    </svg>
                                </a>
                            </div>
                        </li>
                        <?php endwhile; ?>
                        <?php
                        $query = mysqli_query($koneksi, "SELECT * FROM tasks WHERE t_status = 'Done'");
                        if($row = mysqli_fetch_array($query) > 0) :
                        ?>
                        <li class="d-flex justify-content-between align-items-center mt-4">
                            <a href="index.php?drop=ALL-DONE    " class="btn btn-danger">
                                DELETE ALL
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.8824zM2.5 3h11V2h-11z"/>
                                </svg>
                            </a>
                        </li>
                        <?php endif;?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>