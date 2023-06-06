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
    <style type="text/css">
        .bootstrap-tagsinput .tag {
            margin-right: 2px;
            color: white !important;
            background-color: #0d6efd;
            padding: 0.2rem;
        }
    </style>
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
                    <div class="form-group my-3s">
                        <label for="" class="my-4">Enter Blog Content Here</label>
                        <textarea class="form-control" name="blogContent" cols="10" rows="4"></textarea>
                    </div>
                    <div class="form-group my-3s">
                        <label for="" class="my-4">Enter Blog URL Here</label>
                        <input type="text" class="form-control" name="blogUrl" placeholder="Enter Blog Title">
                    </div>
                    <div class="form-group">
                        <label for="" class="my-4">Enter Tags Here</label>
                        <input name='tags' class="form-control" autofocus>
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" name="submitArticle" class="btn btn-success">Submit</button>
                    </div>
                </form>
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