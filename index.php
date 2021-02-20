<?php require_once('./includes/header.php');?>
<?php 
if(isset($_POST['submit'])){
  $user_name=trim($_POST['user']);
  $user_email=trim($_POST['email']);
  $user_password="secret";
  if(empty($user_name) || empty($user_email)) {
                $error = true;
              } 
  else{
  $sql='INSERT INTO `users` ( `user_name`, `user_email`, `user_password`) VALUES (?,?,?)';
  $stmt=mysqli_stmt_init($conn);
              if(!mysqli_stmt_prepare($stmt,$sql)){
                echo "failed";
              }
              else{
                mysqli_stmt_bind_param($stmt,'sss',$user_name,$user_email,$user_password);
                mysqli_stmt_execute($stmt);
              }
}
}
?>
    <div class="container">
        <form class="py-4"action="index.php"method="post">
            <div class="row">
                <div class="col">
                    <input type="text"name="user" class="form-control" placeholder="Username">
                </div>
                <div class="col">
                    <input type="text"name="email" class="form-control" placeholder="Email Address">
                </div>
                <div class="col">
                    <input type="submit"name="submit" class="form-control btn btn-secondary" value="Add New User">
                    <?php echo isset($error) ? "<p>Field can't be blank</p>": ''; ?>
                </div>
            </div>
        </form>
        <h2>All Users</h2>
        <table class="table">
            <thead class="thead-dark">
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql='SELECT * FROM `users`';
              $stmt=mysqli_stmt_init($conn);
              if(!mysqli_stmt_prepare($stmt,$sql)){
                echo "failed";
              }
              else{
                mysqli_stmt_execute($stmt);
                $result=mysqli_stmt_get_result($stmt);
                while($row=mysqli_fetch_assoc($result)){
                  $user_id = $row['user_id'];
                  $user_name = $row['user_name'];
                  $user_email = $row['user_email'];
              ?>
              <tr>
                <th><?php echo "$user_id" ?></th>
                <td><?php echo "$user_name"?></td>
                <td><?php echo "$user_email"?></td>
                <td>
                  <form action="edit-user.php"method="post">
                  <input type="hidden"name="edit"value="<?php echo $user_id ?>">
                  <input type="submit" class="btn btn-link"value="edit"/>
                </form>
                </td>
                <td>
                <form action="index.php"method="post">
                  <input type="hidden"value="<?php echo $user_id ?>" name="udelete">
                  <input type="submit" class="btn btn-link" name="delete" value="Delete"/>
                </form>
                </td>
              </tr>
            </tbody>
            <?php
              }
            }
            ?>
            <?php
              if(isset($_POST['delete'])){
                $user_id=$_POST['udelete'];
                $stmt=mysqli_stmt_init($conn);
                $sql = 'DELETE FROM users WHERE user_id = ?';
                if(!mysqli_stmt_prepare($stmt,$sql)){
                      echo "not connnected";
                  }
                else{
                    mysqli_stmt_bind_param($stmt,'i',$user_id);
                    mysqli_stmt_execute($stmt);
                    header("Location:index.php");
                }
              }
            ?>
        </table>
    </div>
<?php require_once('./includes/footer.php');?>
