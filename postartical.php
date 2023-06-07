<?php
include 'session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Article</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <?php include 'navbar/navbar.php' ?>

    <section class="container">
        <h3 class="text-center my-4">Post Article</h3>
        <div class="row d-flex align-items-center justify-content-center">
            <div class="col-md-6">
                <form action="action.php" method="POST">
                    <div class="form-group my-3s">
                        <label for="" class="my-4">Enter Blog Title</label>
                        <input type="text" class="form-control" name="blogTitle" placeholder="Enter Blog Title">
                    </div>
                    <span class="error-msg"><?php
                                            if (isset($_SESSION['title_error'])) {
                                                echo '<p>' . $_SESSION['title_error'] . '</p>';
                                                unset($_SESSION['title_error']);
                                            }
                                            ?>
                    </span>
                    <div class="form-group my-3s">
                        <label for="" class="my-4">Enter Blog Content Here</label>
                        <textarea class="form-control" name="blogContent" cols="10" rows="4"></textarea>
                    </div>
                    <span class="error-msg"><?php
                                            if (isset($_SESSION['blogcontent_error'])) {
                                                echo '<p>' . $_SESSION['blogcontent_error'] . '</p>';
                                                unset($_SESSION['blogcontent_error']);
                                            }
                                            ?>
                    </span>
                    <div class="form-group my-3s">
                        <label for="" class="my-4">Enter Blog URL Here</label>
                        <input type="text" class="form-control" name="blogUrl" placeholder="Enter Blog URL">
                    </div>
                    <span class="error-msg"><?php
                                            if (isset($_SESSION['blogurl_error'])) {
                                                echo '<p>' . $_SESSION['blogurl_error'] . '</p>';
                                                unset($_SESSION['blogurl_error']);
                                            }
                                            ?>
                    </span>
                    <div class="form-group">
                        <label for="" class="my-4">Enter Tags Here</label>
                        <input name='tags' class="form-control" placeholder="Enter Tags Here">
                    </div>
                    <span class="error-msg"><?php
                                            if (isset($_SESSION['tags_error'])) {
                                                echo '<p>' . $_SESSION['tags_error'] . '</p>';
                                                unset($_SESSION['tags_error']);
                                            }
                                            ?>
                    </span>
                    <div class="text-center mt-4">
                        <button type="submit" name="submitArticle" class="btn btn-success">Submit</button>
                    </div>
                </form>

                <?php
                if (isset($_SESSION['articleMsg']) || isset($_SESSION['articleStatus'])) {

                    if ($_SESSION['articleStatus'] == true) {

                        echo '<div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                        <strong>' . $_SESSION['articleMsg'] . '</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                    } else {
                        // print_r($_SESSION['articleMsg']);
                        echo '<div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                        <strong>' . $_SESSION['articleMsg'] . '</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                    }
                    unset($_SESSION['articleMsg']);
                    unset($_SESSION['articleStatus']);
                }
                ?>
            </div>
        </div>
    </section>

    <!-- <script src="js/bootstrap.bundle.min.js"></script> -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/script.js"></script>
    <script src="https://unpkg.com/@yaireo/tagify"></script>
    <script src="https://unpkg.com/@yaireo/tagify@3.1.0/dist/tagify.polyfills.min.js"></script>
    <script>
        var input = document.querySelector('input[name=tags]');
        new Tagify(input)
    </script>
</body>

</html>