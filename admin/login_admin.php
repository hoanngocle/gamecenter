<!--#####################################################################
    #
    #   File          : LOGIN ADMIN
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
<?php
$title = "Login";
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title><?= $title ?> - Game Magazine Manager </title>

        <link rel="shortcut icon" href="http://s16.postimg.org/9irj2l7n5/gamemagazine.png">
        <link href="assets/css/login-style.css" rel="stylesheet" />
    </head>
    <body>
        <div class="content">
            <?php
                include('../includes/backend/mysqli_connect.php');
                include('../includes/functions.php');
            ?>
            <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $errors = array();
                    $username = $password = FALSE;

                    if (empty($_POST['username'])) {
                        $errors[] = "username";
                    } else {
                        $username = mysqli_real_escape_string($dbc, strip_tags($_POST['username']));
                    }

                    if(isset($_POST['password']) && preg_match('/^[\w]{4,20}$/', $_POST['password'])) {
                        $password = mysqli_real_escape_string($dbc, $_POST['password']);
                    } else {
                        $errors[] = 'password';
                    }

                    if(empty($errors)) {

                    $result = login_admin($username, $password);
                        if(mysqli_num_rows($result) == 1) {
                            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

                            $_SESSION['uid'] = $user['user_id'];
                            $_SESSION['username'] = $user['username'];
                            $_SESSION['email'] = $user['email'];
                            $_SESSION['first_name'] = $user['first_name'];
                            $_SESSION['last_name'] = $user['last_name'];
                            $_SESSION['fullname'] = $user['fullname'];
                            $_SESSION['date_of_birth'] = $user['date_of_birth'];
                            $_SESSION['gender'] = $user['gender'];
                            $_SESSION['website'] = $user['website'];
                            $_SESSION['bio'] = $user['bio'];
                            $_SESSION['avatar'] = $user['avatar'];
                            $_SESSION['user_level'] = $user['user_level'];
                            $_SESSION['LAST_ACTIVITY'] = time();

                            redirect_to('admin/index.php');
                        }else {
                            $fail = $lang['BACKEND_INVALID'];
                        }
                    }
                }
                ?>

            <form action="" name="login-admin" method="post">
                <div class="mat-in">
                    <input type="text" size="20" maxlength="60" tabindex="1" name="username" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>"  placeholder="Username"></input>
                    <span class="bar"></span>
                </div>
                <?php if (isset($errors) && in_array('username', $errors))
                    echo "<p class=error>".$lang['BACKEND_LOGINADMIN']."</p>";
                ?>

                <div class="mat-in">
                    <input type="password" size="20" maxlength="60" tabindex="1" name="password" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>"  placeholder="Password"></input>
                    <span class="bar"></span>
                </div>
                <?php if (isset($errors) && in_array('password', $errors))
                    echo "<p class=error>".$lang['BACKEND_MATKHAU']."</p>"
                ?>

                <?php if (!empty($fail))
                    echo "<p class=error>{$fail}</p>"
                ?>

                <input id="login" type="submit" name="submit" value="Login">

            </form>
        </div>
        <div class="bg-boxes">
            <svg width="300px" height="100%" id="col1">
            <rect width="150px" height="150px" x="75px" y="75px" class="bubble" id="bub1" />
            </svg>
            <svg width="200px" height="100%" id="col2">
            <rect width="100px" height="100px" x="50px" y="50px" class="bubble" id="bub2" />
            </svg>
            <svg width="260px" height="100%" id="col3">
            <rect width="130px" height="130px" x="65px" y="65px" class="bubble" id="bub3" />
            </svg>
            <svg width="160px" height="100%" id="col4">
            <rect width="80px" height="80px" x="40px" y="40px" class="bubble" id="bub4" />
            </svg>
            <svg width="240px" height="100%" id="col5">
            <rect width="120px" height="120px" x="60px" y="60px" class="bubble" id="bub5" />
            </svg>
            <!--Here is a triangle-->
            <svg width="200px" height="100%" id="col6">
            <polygon points="50,150 100,50 150,150" class="bubble" id="bub6" />
            </svg>
            <svg width="200px" height="100%" id="col7">
            <rect width="100px" height="100px" x="50px" y="50px" class="bubble" id="bub7" />
            </svg>
            <svg width="200px" height="100%" id="col8">
            <rect width="100px" height="100px" x="50px" y="50px" class="bubble" id="bub8" />
            </svg>
            <svg width="200px" height="100%" id="col9">
            <rect width="100px" height="100px" x="50px" y="50px" class="bubble" id="bub9" />
            </svg>
            <svg width="200px" height="100%" id="col10">
            <rect width="100px" height="100px" x="50px" y="50px" class="bubble" id="bub10" />
            </svg>
            <svg width="100px" height="100%" id="col11">
            <rect width="50px" height="50px" x="25px" y="25px" class="bubble" id="bub11" />
            </svg>
        </div>
    </body>
</html>