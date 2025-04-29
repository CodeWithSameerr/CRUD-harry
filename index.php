<?php

$insert = false  ;

// DB Connection 
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'notes';

$conn = mysqli_connect($server, $username, $password, $database);

if (!$conn) {

  die("Sorry Database not Connected" . mysqli_connect_error());
}

// Inserting Data query 
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

  $title = $_POST['title']; 
  $description = $_POST['description'];

  $sql = "INSERT INTO `note` (`title`, `description`) VALUES ('$title', '$description')";

  $result = mysqli_query($conn , $sql);

  if($result){
    $insert = true ;
  }else{
    echo "Entry was not inserted Successfully!". mysqli_error($conn);
  }
}

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>iNotes - Notes taking made easy</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">

</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
      <div class="container">
        <a class="navbar-brand" href="#">iNotes</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Services</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="#">Contact Us</a>
            </li>
          </ul>
          <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
        </div>
      </div>
    </nav>
  </header>

  <main>
    <?php 
      if($insert){
          echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your note has been inserted successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
      }

    ?>
    <div class="container my-3">
      <h2>Add a Note</h2>
      <form action="/crud/index.php" method="post">
        <div class="mb-3">
          <label for="title" class="form-label">Note Title</label>
          <input type="text" class="form-control" id="title" name="title">
        </div>

        <div class="mb-3">
          <label for="desc" class="form-label">Note Description</label>
          <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Note</button>
      </form>
    </div>

    <div class="container">

      <table class="table" id="myTable">
        <thead>
          <tr>
            <th scope="col">S.No</th>
            <th scope="col">Title</th>
            <th scope="col">description</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php

          $sql = "SELECT * FROM `note`";
          $result = mysqli_query($conn, $sql);

          $no = 0;
          while ($row = mysqli_fetch_assoc($result)) {

            $no = $no + 1;
            echo "
            <tr>
            <th scope='row'>". $no ."</th>
            <td>" . $row['title'] . "</td>
            <td>" . $row['description'] . "</td>
            <td>Actions</td>
             </tr>";

             
          }
          ?>
       
        </tbody>
      </table>

    </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

  <!-- --- jquery script  -->
  <script src="//cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
  <script>
    let table = new DataTable('#myTable');
  </script>
</body>

</html>