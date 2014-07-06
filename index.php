<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Migrate your Drupal posts into Ghost</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <style type="text/css">
    .container {
      width: 100%;
    }
    .starter-template {

    }
    .title {
      text-align: center;
    }
    .steps {
      border: 1px solid #ddd;
      border-radius: 5px;
      background: #eee;
      padding: 10px 10px 10px 30px;
    } 
  </style>

  <body role="document">
    <div class="container">
      <div class="starter-template col-md-6 col-md-offset-3">
        <h1 class="title">Easily migrate your <a href="http://drupal.org">Drupal 7</a> posts to <a href="http://ghost.org">Ghost</a></h1>
        <img src="drupal-to-ghost.png" width="99%" />
        <hr />
        <ol class="steps">
          <li><p class="lead">Install the <a href="https://drupal.org/project/data_export_import">data_export_import</a> Drupal module</p></li>
          <li><p class="lead">Export nodes and taxonomy to dataset files and download them</p></li>
          <li><p class="lead">Upload these dataset files here and submit</p></li>
          <li><p class="lead">Once you downloaded ghost.json, use it on http://yourghostblog/ghost/debug to import</p></li>
        </ol>

        <form action="convert.php" method="post" enctype= "multipart/form-data"><br>
          <div class="row">
            <div class="lead col-md-6">Nodes dataset: <input class="btn btn-lg btn-default" type="file" name="nodesDataset"></div>
            <div class="lead col-md-6">Taxonomy dataset: <input class="btn btn-lg btn-default" type="file" name="taxonomyDataset"></div>
          </div>
          <input class="btn-primary btn btn-lg btn-default" type="submit" value="Convert">
        </form>

        <hr />
        <div class="well">
          <ul>
            <li><a href="http://ghost.org">Ghost</a> doesn't support importing users (yet)</li>
            <li>Your data is not stored on the server, everything is processed in-memory</li>
            <li>Brought to you by <a href="http://www.shantanutushar.com">Shantanu Tushar</a> and <a href="https://github.com/dpacmittal">Deepak Mittal</a></li>
            <li>Drupal is a <a href="http://drupal.com/trademark" rel="nofollow">registered trademark</a> of <a href="http://buytaert.net" rel="nofollow">Dries Buytaert</a></li>
          </ul>
        </div>
      </div>

    <a href="https://github.com/shaan7/ghost-drupal-import"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/38ef81f8aca64bb9a64448d0d70f1308ef5341ab/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f6461726b626c75655f3132313632312e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png"></a>

    </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  </body>
</html>

