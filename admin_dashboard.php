<?php
session_start();
include("db_connection.php");

/* ===========================
   CHECK ADMIN LOGIN
=========================== */
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$message = "";
$page = isset($_GET['page']) ? $_GET['page'] : "dashboard";

/* ===========================
   ADD CROP
=========================== */
if (isset($_POST['add_crop'])) {

    $stmt = $conn->prepare("INSERT INTO crops 
        (crop_name, season, fertilizer, irrigation, description) 
        VALUES (?, ?, ?, ?, ?)");

    if ($stmt) {

        $stmt->bind_param("sssss",
            $_POST['crop_name'],
            $_POST['season'],
            $_POST['fertilizer'],
            $_POST['irrigation'],
            $_POST['description']
        );

        if ($stmt->execute()) {
            $message = "Crop Added Successfully!";
        } else {
            $message = "Execute Error: " . $stmt->error;
        }

    } else {
        $message = "Prepare Error: " . $conn->error;
    }
}


/* ===========================
   ADD SCHEME
=========================== */
if (isset($_POST['add_scheme'])) {

    $stmt = $conn->prepare("INSERT INTO schemes 
        (scheme_name, description, benefit, eligibility) 
        VALUES (?, ?, ?, ?)");

    $stmt->bind_param("ssss",
        $_POST['scheme_name'],
        $_POST['scheme_desc'],
        $_POST['benefit'],
        $_POST['eligibility']
    );

    if ($stmt->execute()) {
        $message = "Scheme Added Successfully!";
    }
}

/* ===========================
   APPROVE / REJECT APPLICATION
=========================== */
if (isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    mysqli_query($conn, "UPDATE applications SET status='Approved' WHERE application_id=$id");
}

if (isset($_GET['reject'])) {
    $id = intval($_GET['reject']);
    mysqli_query($conn, "UPDATE applications SET status='Rejected' WHERE application_id=$id");
}

/* ===========================
   COUNT FUNCTION
=========================== */
function getCount($conn, $table) {
    $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM $table");
    return ($result) ? mysqli_fetch_assoc($result)['total'] : 0;
}

$user_count   = getCount($conn, "users");
$scheme_count = getCount($conn, "schemes");
$crop_count   = getCount($conn, "crops");
$app_count    = getCount($conn, "applications");
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard | Agro-Web-App</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body { background:#f4f6f9; }

.sidebar {
    height:100vh;
    background:#198754;
    padding:20px;
    color:white;
}

.sidebar a {
    color:white;
    display:block;
    padding:12px;
    text-decoration:none;
    margin-bottom:8px;
    border-radius:6px;
    transition:0.3s;
}

.sidebar a:hover {
    background:#146c43;
}

.card { border-radius:12px; }
</style>
</head>

<body>

<div class="container-fluid">
<div class="row">

<!-- ================= SIDEBAR ================= -->
<div class="col-md-3 sidebar">
    <h4>🌾 Admin Panel</h4>
    <hr>

    <a href="admin_dashboard.php?page=dashboard">🏠 Dashboard</a>
    <a href="admin_dashboard.php?page=add_crop">🌱 Add Crop</a>
    <a href="admin_dashboard.php?page=add_scheme">🏛 Add Scheme</a>
    <a href="admin_dashboard.php?page=applications">📋 Applications</a>
    <a href="logout.php">🚪 Logout</a>
</div>

<!-- ================= MAIN CONTENT ================= -->
<div class="col-md-9 p-4">

<?php if($message!=""){ ?>
<div class="alert alert-success"><?php echo $message; ?></div>
<?php } ?>

<?php
/* ================= DASHBOARD ================= */
if ($page == "dashboard") {
?>

<h3>Welcome Admin 👨‍💼</h3>

<div class="row g-4 mt-3">
    <div class="col-md-3">
        <div class="card shadow text-center p-3">
            <h6>Total Users</h6>
            <h3><?php echo $user_count; ?></h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow text-center p-3">
            <h6>Total Schemes</h6>
            <h3><?php echo $scheme_count; ?></h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow text-center p-3">
            <h6>Total Crops</h6>
            <h3><?php echo $crop_count; ?></h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow text-center p-3">
            <h6>Total Applications</h6>
            <h3><?php echo $app_count; ?></h3>
        </div>
    </div>
</div>

<?php } ?>


<?php
/* ================= ADD CROP ================= */
if ($page == "add_crop") {
?>

<h4>Add Crop</h4>
<div class="card shadow p-4 mb-4">
<form method="POST">
    <input type="text" name="crop_name" class="form-control mb-2" placeholder="Crop Name" required>
    <input type="text" name="season" class="form-control mb-2" placeholder="Season" required>
    <input type="text" name="fertilizer" class="form-control mb-2" placeholder="Fertilizer" required>
    <input type="text" name="irrigation" class="form-control mb-2" placeholder="Irrigation" required>
    <textarea name="description" class="form-control mb-2" placeholder="Description" required></textarea>
    <button type="submit" name="add_crop" class="btn btn-success">Add Crop</button>
</form>
</div>

<h5>Previously Added Crops</h5>
<div class="card shadow p-4">
<table class="table table-bordered">
<tr>
<th>ID</th>
<th>Name</th>
<th>Season</th>
<th>Fertilizer</th>
<th>Irrigation</th>
</tr>

<?php
$crops = mysqli_query($conn,"SELECT * FROM crops ORDER BY crop_id DESC");
while($row = mysqli_fetch_assoc($crops)) {
?>
<tr>
<td><?php echo $row['crop_id']; ?></td>
<td><?php echo $row['crop_name']; ?></td>
<td><?php echo $row['season']; ?></td>
<td><?php echo $row['fertilizer']; ?></td>
<td><?php echo $row['irrigation']; ?></td>
</tr>
<?php } ?>
</table>
</div>

<?php } ?>


<?php
/* ================= ADD SCHEME ================= */
if ($page == "add_scheme") {
?>

<h4>Add Government Scheme</h4>
<div class="card shadow p-4 mb-4">
<form method="POST">
    <input type="text" name="scheme_name" class="form-control mb-2" placeholder="Scheme Name" required>
    <textarea name="scheme_desc" class="form-control mb-2" placeholder="Description" required></textarea>
    <input type="text" name="benefit" class="form-control mb-2" placeholder="Benefit" required>
    <input type="text" name="eligibility" class="form-control mb-2" placeholder="Eligibility" required>
    <button type="submit" name="add_scheme" class="btn btn-primary">Add Scheme</button>
</form>
</div>

<h5>Previously Added Schemes</h5>
<div class="card shadow p-4">
<table class="table table-bordered">
<tr>
<th>ID</th>
<th>Name</th>
<th>Benefit</th>
<th>Eligibility</th>
</tr>

<?php
$schemes = mysqli_query($conn,"SELECT * FROM schemes ORDER BY scheme_id DESC");
while($row = mysqli_fetch_assoc($schemes)) {
?>
<tr>
<td><?php echo $row['scheme_id']; ?></td>
<td><?php echo $row['scheme_name']; ?></td>
<td><?php echo $row['benefit']; ?></td>
<td><?php echo $row['eligibility']; ?></td>
</tr>
<?php } ?>
</table>
</div>

<?php } ?>


<?php
/* ================= APPLICATIONS ================= */
if ($page == "applications") {
?>

<h4>Farmer Applications</h4>
<div class="card shadow p-4">
<table class="table table-bordered">
<tr>
<th>ID</th>
<th>User ID</th>
<th>Scheme ID</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php
$apps = mysqli_query($conn,"SELECT * FROM applications ORDER BY application_id DESC");
while($row = mysqli_fetch_assoc($apps)) {
?>
<tr>
<td><?php echo $row['application_id']; ?></td>
<td><?php echo $row['user_id']; ?></td>
<td><?php echo $row['scheme_id']; ?></td>
<td><?php echo $row['status']; ?></td>
<td>
<a href="?page=applications&approve=<?php echo $row['application_id']; ?>" class="btn btn-success btn-sm">Approve</a>
<a href="?page=applications&reject=<?php echo $row['application_id']; ?>" class="btn btn-danger btn-sm">Reject</a>
</td>
</tr>
<?php } ?>
</table>
</div>

<?php } ?>

</div>
</div>
</div>

</body>
</html>
