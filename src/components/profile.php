<?php
session_start();

if (
  $_SERVER['REQUEST_METHOD'] === 'POST' &&
  isset($_FILES['profile_picture']) &&
  $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK
) {
  $targetDir = 'uploads/';
  if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);

  $fileName = basename($_FILES['profile_picture']['name']);
  $targetFilePath = $targetDir . time() . '_' . $fileName;
  $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

  $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
  if (in_array($fileType, $allowedTypes)) {
    if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetFilePath)) {
      $_SESSION['uploaded_photo'] = $targetFilePath;
    } else {
      echo "<script>alert('Failed to upload file.');</script>";
    }
  } else {
    echo "<script>alert('Only JPG, JPEG, PNG, GIF are allowed.');</script>";
  }
}

$user = [
  'name' => 'John Ryan Dela Cruz',
  'email' => 'johnryan.delacruz@gmail.com',
  'location' => 'Iligan City',
  'phone' => '09123456789',
  'details' => [
    'Affiliation' => 'College Graduate',
    'Status' => 'Active',
    'Sex' => 'Male',
    'Civil Status' => 'Married',
    'Citizenship' => 'Filipino',
    'Birthdate' => '2025-02-17',
    'Birthplace' => 'Unknown',
    'Religion' => 'Unknown',
    'Permanent Address' => 'Iligan City'
  ]
];

$adminData = [
  'employee_number' => '2025-0001',
  'position' => 'Engineer IV',
  'division' => 'Admin'
];

$serviceRecords = [
  ['start' => '2020-01-01', 'end' => '2022-12-31', 'position' => 'Engineer IV', 'division' => 'Admin'],
  ['start' => '2018-06-15', 'end' => '2019-12-31', 'position' => 'Senior Developer', 'division' => 'IT'],
  ['start' => '2015-03-10', 'end' => '2018-06-14', 'position' => 'Software Developer', 'division' => 'IT']
];

$recordsPerPage = 2;
$totalRecords = count($serviceRecords);
$totalPages = ceil($totalRecords / $recordsPerPage);
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$currentPage = max(1, min($currentPage, $totalPages));
$offset = ($currentPage - 1) * $recordsPerPage;
$pagedRecords = array_slice($serviceRecords, $offset, $recordsPerPage);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body { font-family: Arial, sans-serif; margin: 0; }
    .header {
      background: #2C3E50;
      color: white;
      padding: 15px 20px;
      display: flex;
      align-items: center;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 1000;
    }
    .content {
      margin-left: 0;
      padding: 80px 20px 20px;
      transition: margin-left 0.3s ease-in-out;
    }
    .content.shifted { margin-left: 250px; }
    .profile-card, .details-card {
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
      background: white;
    }
    .breadcrumb-custom {
      font-size: 14px;
    }
    .breadcrumb-link {
      color: #6c757d;
      text-decoration: none;
      transition: color 0.3s ease;
    }
    .breadcrumb-link:hover {
      color: #0d6efd;
    }
    .profile-pic-container {
      position: relative;
      width: 150px;
      height: 150px;
      margin: 0 auto;
      
    }
    .profile-img-preview {
      width: 100%;
      height: 100%;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #ddd;
    }
    .upload-overlay {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 100%;
      border-radius: 50%;
      background-color: rgba(0, 0, 0, 0.6);
      color: #ffd700;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      opacity: 0;
      font-size: 14px;
      cursor: pointer;
      transition: opacity 0.3s ease;
    }
    .upload-overlay i { font-size: 18px; margin-bottom: 5px; }
    .profile-pic-container:hover .upload-overlay { opacity: 1; }
    .btn-container { text-align: right; }
    @media (max-width: 768px) {
      .content.shifted { margin-left: 0; }
    }
    .pagination-container { margin-top: 50px; }
  </style>
</head>
<body>

<?php include __DIR__ . '/../hero/navbar.php'; ?>
<?php include __DIR__ . '/../hero/sidebar.php'; ?>

<div class="content" id="content">
  <!-- Header and Breadcrumb -->
  <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
            <h4 class="mb-0" style="font-weight: bold;">Profile</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a class="breadcrumb-link" href="/src/index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
        </nav>
        </div>
  <div class="container mt-4">
    <div class="row">
      <div class="col-md-3">
        <div class="card profile-card text-center">
          <form method="POST" enctype="multipart/form-data">
            <div class="profile-pic-container">
              <img
                id="profileImage"
                src="<?php echo isset($_SESSION['uploaded_photo']) ? $_SESSION['uploaded_photo'] : '/assets/profile.jpg'; ?>"
                alt="Profile Picture"
                class="profile-img-preview"
                style="object-position: 50% 50%;"
              >
              <label for="profileUpload" class="upload-overlay">
                <i class="fas fa-camera"></i> Update Photo
              </label>
              <input
                type="file"
                id="profileUpload"
                name="profile_picture"
                accept="image/*"
                class="d-none"
                onchange="this.form.submit()"
              >
            </div>
          </form>
          <h5 class="mt-2"><?php echo $user['name']; ?></h5>
          <p class="text-muted"><i><?php echo $user['email']; ?></i></p>
          <hr>
          <p><i class="fas fa-map-marker-alt"></i> <?php echo $user['location']; ?> &nbsp;|&nbsp; <i class="fas fa-phone"></i> <?php echo $user['phone']; ?></p>
        </div>

        <div class="card details-card mt-3">
          <h6 class="fw-bold" style="font-size: 18px;">Personal Details</h6>
          <hr>
          <?php foreach ($user['details'] as $key => $value) { ?>
            <p><strong><?php echo $key; ?>:</strong> <?php echo $value; ?></p>
          <?php } ?>
        </div>
      </div>

      <div class="col-md-9">
        <div class="card p-3 profile-card">
          <div class="btn-container">
          <a href="/src/components/edit_regular.php" class="btn btn-success">Update</a>
            <button class="btn btn-warning">Print</button>
          </div>
          <h5 class="fw-bold mt-3">Admin Data</h5>
          <p><strong>Employee Number:</strong> <?php echo $adminData['employee_number']; ?></p>
          <p><strong>Position:</strong> <?php echo $adminData['position']; ?></p>
          <p><strong>Division:</strong> <?php echo $adminData['division']; ?></p>

          <hr>
          <h5 class="fw-bold">Service Record</h5>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Starting Date</th>
                <th>Ending Date</th>
                <th>Position</th>
                <th>Division</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($pagedRecords as $record) { ?>
                <tr>
                  <td><?php echo $record['start']; ?></td>
                  <td><?php echo $record['end']; ?></td>
                  <td><?php echo $record['position']; ?></td>
                  <td><?php echo $record['division']; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
          <nav class="pagination-container">
            <ul class="pagination pagination-sm justify-content-center">
              <?php if ($currentPage > 1): ?>
                <li class="page-item">
                  <a class="page-link prev-next" href="?page=<?php echo $currentPage - 1; ?>">« Prev</a>
                </li>
              <?php endif; ?>
              <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                  <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
              <?php endfor; ?>
              <?php if ($currentPage < $totalPages): ?>
                <li class="page-item">
                  <a class="page-link prev-next" href="?page=<?php echo $currentPage + 1; ?>">Next »</a>
                </li>
              <?php endif; ?>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <?php include __DIR__ . '/../hero/footer.php'; ?>
</div>

</body>
</html>