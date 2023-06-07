<?php
include 'session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Multiple Image</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include 'navbar/navbar.php' ?>

    <section class="container">
        <h3 class="text-center my-4">Post Multiple Image</h3>
        <div class="row d-flex align-items-center justify-content-center">
            <div class="col-md-6">
                <form action="post_multiple_image_action.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="" class="my-4">Enter your content here</label>
                        <textarea class="form-control" name="content" cols="10" rows="4"></textarea>
                    </div>
                    <span class="error-msg"><?php
                                            if (isset($_SESSION['contentErr'])) {
                                                echo '<p>' . $_SESSION['contentErr'] . '</p>';
                                                unset($_SESSION['contentErr']);
                                            }
                                            ?>
                    </span>
                    <div class="form-group">
                        <label for="" class="my-4">Enter your content here</label>
                        <input type="file" class="form-control" name="image[]" multiple>
                    </div>
                    <span class="error-msg"><?php
                                            if (isset($_SESSION['imageErr'])) {
                                                echo '<p>' . $_SESSION['imageErr'] . '</p>';
                                                unset($_SESSION['imageErr']);
                                            }
                                            ?>
                    </span>
                    <div class="text-center mt-4">
                        <button type="submit" name="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>

                <?php
                if (isset($_SESSION['imgsMessage']) && isset($_SESSION['imgPostsStatus'])) {
                    if ($_SESSION['imgPostsStatus'] == true) {
                        echo '<div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                        <strong>' . $_SESSION['imgsMessage'] . '</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                    } else {
                        echo '<div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                        <strong>' . $_SESSION['imgsMessage'] . '</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                    }
                    unset($_SESSION['imgsMessage']);
                    unset($_SESSION['imgPostsStatus']);
                }
                ?>
            </div>
        </div>
    </section>

    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>