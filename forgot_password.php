<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Emmanuel">
    <meta name="robots" name="noindex,nofollow">
    <meta name="description" name="join the best platform for household in need of freelance house keepers">
    <title>Reset Password</title>
    <?php require_once "partials/style.php"; ?>
</head>
<body>
    <div class="container-fluid">
           
                  <!-- Navbar section -->
                <?php require_once "partials/navbar.php";    ?>
            

        <div class="row mt-5">
            <div class="col-md-4 offset-4 mt-5">
                <form action="">
                    <div class="form-group">
                        <label class="mb-2" for="email">Enter registered Email</label>
                        <input type="email" class="form-control" name="email" id="email">
                    </div>
                    <div class="form-group text-center my-4">
                        <button class="btn btn-primary">Send Code</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 offset-2">
                 <div class="my-2 form-group">
                    <h4>Change Password</h4>
                    <label for="old_pwd">Old Password:</label>
                    <input type="password" name="old_pwd" id="old_pwd" class="form-control" required>
                    <label for="new_pwd">New Password:</label>
                    <input type="password" name="new_pwd" id="new_pwd" class="form-control" required>
                    <label for="cpwd">Confirm Password:</label>
                    <input type="password" name="cpwd" id="cpwd" class="form-control" required>
                    <input type="checkbox" name="show_pwd" id="show_pwd" >
                     <label for="show_pwd">Show password</label>
                </div>
                <div class="mt-3 text-center form-group ">
                    <button class="btn w-100 btn-lg btn-primary my-5">Save</button>
                </div>
            </div>
        </div>
        <?php require_once "partials/footer.php"; ?>
    </div>
</body>
</html>