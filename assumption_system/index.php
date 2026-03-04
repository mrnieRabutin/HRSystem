<?php 
include 'config.php';
session_start();

/* ================= SEARCH ================= */
$search = isset($_GET['search']) ? $_GET['search'] : '';
?>
<!DOCTYPE html>
<html>
<head>
<title>CS FORM NO. 4</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
body {
    background: linear-gradient(135deg, #f1f5ff, #eef2f7);
    font-family: 'Poppins', sans-serif;
}

.navbar {
    background: linear-gradient(135deg, #0038A8, #0056d6);
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

.table thead {
    background: linear-gradient(135deg, #0038A8, #0056d6);
    color: white;
}

.table tbody tr:hover {
    background: #eef3ff;
}

.btn { border-radius: 10px; }

.modal-header {
    background: linear-gradient(135deg, #0038A8, #0056d6);
    color: white;
}

/* DARK MODE */
body.dark-mode {
    background: #121212;
    color: #e4e4e4;
}

body.dark-mode .card {
    background: #1e1e1e;
    color: #e4e4e4;
}

body.dark-mode .table { color: #e4e4e4; }
body.dark-mode .table thead { background: #002b80; }

body.dark-mode .modal-content {
    background: #1e1e1e;
    color: white;
}

body.dark-mode .form-control {
    background: #2c2c2c;
    border: 1px solid #444;
    color: white;
}

.toggle-btn {
    cursor: pointer;
    font-size: 18px;
    color: white;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark">
<div class="container-fluid d-flex justify-content-between align-items-center">
    
    <div class="d-flex align-items-center">
        <img src="../depedlogo2.jpg" style="width:55px; margin-right:12px;">
        <div class="text-white">
            <div class="fw-semibold">Department of Education</div>
            <div style="font-size:13px;">DIVISION OF SOUTHERN LEYTE</div>
            <div style="font-size:12px;">CS FORM NO. 4</div>
        </div>
    </div>

    <div class="d-flex align-items-center">
        <!-- DARK MODE -->
        <i class="bi bi-moon-stars toggle-btn me-3" id="darkToggle"></i>

        <!-- ADD -->
        <button class="btn btn-light btn-sm me-2" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="bi bi-plus-circle"></i> Add New Record
        </button>

        <!-- LOGOUT -->
        <a href="logout.php" class="btn btn-danger btn-sm">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>

</div>
</nav>

<div class="container mt-4">
<div class="card-body">
<!-- ================= SEARCH CONTAINER ================= -->
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form class="row g-3 align-items-center" method="GET">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control"
                        placeholder="Search Fullname, Position, Office..."
                        value="<?php echo htmlspecialchars($search); ?>">
                </div>

                <div class="col-md-auto">
                    <button class="btn btn-primary">
                        <i class="bi bi-search"></i> Search
                    </button>
                    <a href="index.php" class="btn btn-secondary">Reset</a>
                </div>
            </form>

        </div>
    </div>
</div>



<!-- ================= TABLE CONTAINER ================= -->
<div class="container mt-3">
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="card">
      <div class="card-header custom-header">
        <h5 class="mb-0 fw-semibold">Certificate of Assumption</h5>
      </div>

            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th width="220">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

<?php
if($search != ''){
    $stmt = $conn->prepare("SELECT * FROM assumption_records 
        WHERE fullname LIKE ? 
        OR position LIKE ? 
        OR office LIKE ?
        ORDER BY id DESC");

    $like = "%$search%";
    $stmt->bind_param("sss", $like, $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM assumption_records ORDER BY id DESC");
}

while($row = $result->fetch_assoc()) {
echo "<tr>
<td>{$row['id']}</td>
<td class='fw-semibold text-primary'>{$row['fullname']}</td>
<td>{$row['position']}</td>
<td>{$row['office']}</td>
<td>
<button class='btn btn-warning btn-sm me-1' onclick='openEditModal({$row['id']})'>
<i class='bi bi-pencil'></i>
</button>
<button class='btn btn-danger btn-sm me-1' onclick='openDeleteModal({$row['id']})'>
<i class='bi bi-trash'></i>
</button>
<a href='print.php?id={$row['id']}' target='_blank' class='btn btn-success btn-sm'>
<i class='bi bi-printer'></i>
</a>
</td>
</tr>";
}
?>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- ADD MODAL -->
<div class="modal fade" id="addModal">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Add New Record</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
<form action="save.php" method="POST">

<?php
$fields = [
'fullname','position','office','effective_date',
'appointment_name','appointment_position',
'day_signed','month_signed','year_signed',
'sig_name','sig_rank','sig_place',
'hrmo_name','hrmo_rank'
];

foreach($fields as $field){
echo "<input type='".($field=='effective_date'?'date':'text')."' 
name='$field' class='form-control mb-3'
placeholder='".ucwords(str_replace('_',' ',$field))."' required>";
}
?>

<button type="submit" class="btn btn-primary w-100">Save Record</button>
</form>
</div>
</div>
</div>
</div>

<!-- EDIT MODAL -->
<div class="modal fade" id="editModal">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Edit Record</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
<form method="POST" action="edit.php">
<input type="hidden" name="id" id="edit_id">

<?php
foreach($fields as $field){
echo "<input type='".($field=='effective_date'?'date':'text')."'
name='$field' id='edit_$field'
class='form-control mb-3'
placeholder='".ucwords(str_replace('_',' ',$field))."' required>";
}
?>

<button type="submit" class="btn btn-warning w-100">Update Record</button>
</form>
</div>
</div>
</div>
</div>

<!-- DELETE MODAL -->
<div class="modal fade" id="deleteModal">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Confirm Delete</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body text-center">
<form method="POST" action="delete.php">
<input type="hidden" name="id" id="delete_id">
<p>Are you sure you want to delete this record?</p>
<button type="submit" class="btn btn-danger">Delete</button>
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
</form>
</div>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
// EDIT
function openEditModal(id){
fetch('get_record.php?id='+id)
.then(res=>res.json())
.then(data=>{
document.getElementById('edit_id').value=data.id;
<?php foreach($fields as $field){
echo "document.getElementById('edit_$field').value=data.$field;\n";
} ?>
new bootstrap.Modal(document.getElementById('editModal')).show();
});
}

// DELETE
function openDeleteModal(id){
document.getElementById('delete_id').value=id;
new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

// DARK MODE
const toggle=document.getElementById("darkToggle");

if(localStorage.getItem("darkMode")==="enabled"){
document.body.classList.add("dark-mode");
toggle.classList.replace("bi-moon-stars","bi-sun");
}

toggle.addEventListener("click",function(){
document.body.classList.toggle("dark-mode");
if(document.body.classList.contains("dark-mode")){
localStorage.setItem("darkMode","enabled");
toggle.classList.replace("bi-moon-stars","bi-sun");
}else{
localStorage.setItem("darkMode","disabled");
toggle.classList.replace("bi-sun","bi-moon-stars");
}
});
</script>

</body>
</html>