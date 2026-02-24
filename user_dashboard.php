<?php
session_start();
include("db_connection.php");

// For testing (remove login check if you don't want login)
$user_id = 1; // Static user ID (change if needed)

// Handle Scheme Apply
if (isset($_POST['apply_scheme'])) {

    $scheme_id = intval($_POST['scheme_id']);

    $check = mysqli_query($conn, "SELECT * FROM applications 
                                  WHERE user_id='$user_id' 
                                  AND scheme_id='$scheme_id'");

    if (mysqli_num_rows($check) == 0) {
        mysqli_query($conn, "INSERT INTO applications (user_id, scheme_id, status) 
                             VALUES ('$user_id','$scheme_id','Pending')");
        $msg = "Application Submitted Successfully!";
    } else {
        $msg = "You already applied for this scheme!";
    }
}

// Counts
$crop_count   = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM crops"));
$scheme_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM schemes"));
$app_count    = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM applications WHERE user_id='$user_id'"));

?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background:#f4f6f9; }
        .sidebar {
            background:#198754;
            height:100vh;
            padding:20px;
            color:white;
        }
        .sidebar a {
            display:block;
            padding:10px;
            color:white;
            text-decoration:none;
            border-radius:6px;
            margin-bottom:10px;
        }
        .sidebar a:hover {
            background:#146c43;
        }
        .card {
            border-radius:15px;
        }
    </style>
</head>

<body>

<div class="container-fluid">
<div class="row">

<!-- SIDEBAR -->
<div class="col-md-3 sidebar">
    <h4>🌾 Farmer Panel</h4>
    <hr>

    <a href="?page=dashboard">🏠 Dashboard</a>
    <a href="?page=crops">🌱 View Crops</a>
    <a href="?page=schemes">🏛 View Schemes</a>
    <a href="?page=status">📊 View Status</a>
    <a href="logout.php">🚪 Logout</a>
</div>

<!-- MAIN CONTENT -->
<div class="col-md-9 p-4">

<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

if ($page == "dashboard") {
?>

<h3>Welcome Farmer 👨‍🌾</h3>
<hr>

<div class="row mt-4">

<div class="col-md-4">
    <div class="card shadow text-center p-4">
        <h5>Total Crops</h5>
        <h2 class="text-success"><?php echo $crop_count; ?></h2>
    </div>
</div>

<div class="col-md-4">
    <div class="card shadow text-center p-4">
        <h5>Total Schemes</h5>
        <h2 class="text-primary"><?php echo $scheme_count; ?></h2>
    </div>
</div>

<div class="col-md-4">
    <div class="card shadow text-center p-4">
        <h5>Your Applications</h5>
        <h2 class="text-warning"><?php echo $app_count; ?></h2>
    </div>
</div>

</div>

<?php
}

/* VIEW CROPS */
if ($page == "crops") {
    echo "<h4>🌱 Crop Details</h4><hr>";

    $crops = mysqli_query($conn, "SELECT * FROM crops");

    while ($row = mysqli_fetch_assoc($crops)) {
        echo "<div class='card mb-3 p-3 shadow'>";
        echo "<h5>".$row['crop_name']."</h5>";
        echo "<p>".$row['description']."</p>";
        echo "<b>Season:</b> ".$row['season'];
        echo "</div>";
    }
}

/* VIEW SCHEMES + APPLY */
if ($page == "schemes") {
    echo "<h4>🏛 Government Schemes</h4><hr>";

    if (isset($msg)) {
        echo "<div class='alert alert-info'>$msg</div>";
    }

    $schemes = mysqli_query($conn, "SELECT * FROM schemes");

    while ($row = mysqli_fetch_assoc($schemes)) {

        echo "<div class='card mb-3 p-3 shadow'>";
        echo "<h5>".$row['scheme_name']."</h5>";
        echo "<p>".$row['description']."</p>";

        echo "<form method='POST'>";
        echo "<input type='hidden' name='scheme_id' value='".$row['scheme_id']."'>";
        echo "<button type='submit' name='apply_scheme' class='btn btn-success'>Apply</button>";
        echo "</form>";

        echo "</div>";
    }
}

/* VIEW STATUS */
if ($page == "status") {
    echo "<h4>📊 Application Status</h4><hr>";

    $apps = mysqli_query($conn, "
        SELECT schemes.scheme_name, applications.status
        FROM applications
        JOIN schemes ON schemes.scheme_id = applications.scheme_id
        WHERE applications.user_id='$user_id'
    ");

    echo "<table class='table table-bordered'>";
    echo "<tr><th>Scheme</th><th>Status</th></tr>";

    while ($row = mysqli_fetch_assoc($apps)) {
        echo "<tr>";
        echo "<td>".$row['scheme_name']."</td>";
        echo "<td>".$row['status']."</td>";
        echo "</tr>";
    }

    echo "</table>";
}
?>

</div>
</div>
</div>

</body>
</html>
