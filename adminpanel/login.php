<?php
    session_start();
    require "../koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>

<style>
    .main{
        height: 100vh;
    }

    .login-box{
        width: 500px;
        height: 300px;
        box-sizing: border-box;
        border-radius: 10px;
    }
</style>

<body>
    <div class="main d-flex flex-column justify-content-center align-items-center">
        <div class="login-box p-5 shadow">
            <form action="" method="post">
                <div>
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username">
                </div>
                <div>
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <div>
                    <button class="btn btn-success form_control mt-3" type="submit" name="loginbtn">Login</button>
                </div>
            </form>
        </div>
        
        <div class="mt-3" style="width= 500px">
            <?php
                if(isset($_POST['loginbtn'])){
                    $username = htmlspecialchars($_POST['username']);
                    $password = htmlspecialchars($_POST['password']);

                    $query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
                    $countdata = mysqli_num_rows($query);
                    $data = mysqli_fetch_array($query);
                    
                    if($countdata>0){
                        if (password_verify($password, $data['password'])) {
                            $_SESSION['username'] = $data['username'];
                            $_SESSION['login'] = true;
                            $_SESSION['usertype'] = $data['usertype'];

                            if($_SESSION['usertype'] === 'user'){
                                header('location: user_page.php');
                            }else if($_SESSION['usertype'] === 'admin'){
                                header('location: admin_page.php');
                            }else{
                                echo '<div class="alert alert-warning" role="alert">Invalid user type!</div>';
                            }
                        }else{
                            ?>
                            <div class="alert alert-warning" role="alert">
                                Password salah
                            </div>
                            <?php
                        }
                    }else{
                        ?>
                        <div class="alert alert-warning" role="alert">
                            Akun tidak tersedia
                        </div>
                        <?php
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>
