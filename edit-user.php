<?php require_once('./includes/header.php');?>
    <div class="container">
        <h2 class="pt-4">User Update</h2>
        <?php
        if(isset($_POST['change'])){
        $user_id=$_POST['id'];
        $user_name=trim($_POST['user']);
        $user_email=trim($_POST['email']);
        $user_password=trim($_POST['pwd']);
        if(empty($user_name) || empty($user_email) || empty($user_password)) {
                $error = true;
        } 
    else{
    $sql=$sql='UPDATE users SET user_name = ?, user_email = ?, user_password = ? WHERE user_id = ?';
    $stmt=mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$sql)){
                echo "failed";
            }
            else{
                mysqli_stmt_bind_param($stmt,'sssi',$user_name,$user_email,$user_password,$user_id);
                mysqli_stmt_execute($stmt);
                header("location:index.php");
            }
}
}
?>
        <?php 
        if(isset($_POST['edit'])){
            $user_id=$_POST['edit'];
            $sql='SELECT * FROM `users`WHERE user_id=?';
            $stmt=mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$sql)){
                echo "failed";
            }
            else{
                mysqli_stmt_bind_param($stmt,'i',$user_id);
                mysqli_stmt_execute($stmt);
                $result=mysqli_stmt_get_result($stmt);
                while($row=mysqli_fetch_assoc($result)){
                $user_password= $row['user_password'];
                $user_name = $row['user_name'];
                $user_email = $row['user_email'];
            ?>
        <form class="py-2"action="edit-user.php"method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control"name="user" id="username" value="<?php echo $user_name ?>"placeholder="Desired username">
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control"name="email" id="email" value="<?php echo $user_email ?>" placeholder="Desired email address">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control"name="pwd"id="password" value="<?php echo $user_password ?>" placeholder="Enter new password">
            </div>
            <input type="hidden" name="id" value="<?php echo $user_id?>">
            <?php
                }
            }
        }
            ?>
            <button type="submit"name="change" value="change"class="btn btn-primary">Submit</button>
        </form>
    </div>
<?php require_once('./includes/footer.php');?>
