<?php
session_start();
include_once __DIR__ . '/../../backend/db.php'; // Path to your db connection file

// Assume the employee's Emp_No is passed via GET parameter
$emp_no = $_GET['Emp_No'] ?? null; // Get Emp_No from GET parameter
$action = $_GET['action'] ?? null;

if (!$emp_no) {
    echo "Employee not found.";
    exit();
}

// Query to get employee details from 'personnel' table
$query = $conn->prepare("SELECT * FROM personnel WHERE Emp_No = ?");
$query->bind_param("s", $emp_no);
$query->execute();
$result = $query->get_result();
$employee = $result->fetch_assoc();

if (!$employee) {
    echo "Employee not found.";
    exit();
}

// Query to get salary details from 'salary' table
$query_salary = $conn->prepare("SELECT * FROM salary WHERE personnel_id = ?");
$query_salary->bind_param("i", $employee['personnel_id']);
$query_salary->execute();
$salary = $query_salary->get_result()->fetch_assoc();

// Query to get reg_emp details from 'reg_emp' table
$query_reg_emp = $conn->prepare("SELECT * FROM reg_emp WHERE personnel_id = ?");
$query_reg_emp->bind_param("i", $employee['personnel_id']);
$query_reg_emp->execute();
$reg_emp = $query_reg_emp->get_result()->fetch_assoc();

// Access plantillaNo and acaPera
$plantillaNo = $reg_emp['plantillaNo'] ?? null; // Handle case where it's null
$acaPera = $reg_emp['acaPera'] ?? null; // Handle case where it's null

// Check employment type (e.g., 'regular', 'job_order', 'contract')
$employment_type = ''; // Default to empty string
if (isset($reg_emp['plantillaNo']) && !empty($reg_emp['plantillaNo'])) {
    $employment_type = 'regular';
} elseif (isset($employee['job_order']) && !empty($employee['job_order'])) {
    $employment_type = 'job_order';
} elseif (isset($employee['contract_status']) && !empty($employee['contract_status'])) {
    $employment_type = 'contract';
}

// Query to get job order details from 'job_order' table if applicable
$job_orders = [];
if ($employment_type === 'job_order') {
    $query_jo = $conn->prepare("SELECT * FROM job_order WHERE personnel_id = ?");
    $query_jo->bind_param("i", $employee['personnel_id']);
    $query_jo->execute();
    $job_orders = $query_jo->get_result();
}

// Query to get contract details from 'contract_service' table if applicable
$contracts = [];
if ($employment_type === 'contract') {
    $query_cos = $conn->prepare("SELECT * FROM contract_service WHERE personnel_id = ?");
    $query_cos->bind_param("i", $employee['personnel_id']);
    $query_cos->execute();
    $contracts = $query_cos->get_result();
}

// If the action is not explicitly "delete," do not execute the delete logic
if ($action === 'delete') {
  // Begin database transaction
  $conn->begin_transaction();

  try {
      // Query to get the personnel_id for the given Emp_No
      $query_personnel = $conn->prepare("SELECT personnel_id FROM personnel WHERE Emp_No = ?");
      $query_personnel->bind_param("s", $emp_no);
      $query_personnel->execute();
      $result = $query_personnel->get_result();
      $personnel = $result->fetch_assoc();

      if (!$personnel) {
          throw new Exception("Employee not found.");
      }

      $personnel_id = $personnel['personnel_id'];

      // Delete from dependent tables in the correct order
      // Step 1: Delete from reg_emp table
      $query_reg_emp = $conn->prepare("DELETE FROM reg_emp WHERE personnel_id = ?");
      $query_reg_emp->bind_param("i", $personnel_id);
      if (!$query_reg_emp->execute()) {
          throw new Exception("Failed to delete from reg_emp: " . $query_reg_emp->error);
      }

      // Step 2: Delete from salary table
      $query_salary = $conn->prepare("DELETE FROM salary WHERE salary_id = (SELECT salary_id FROM reg_emp WHERE personnel_id = ?)");
      $query_salary->bind_param("i", $personnel_id);
      if (!$query_salary->execute()) {
          throw new Exception("Failed to delete from salary: " . $query_salary->error);
      }

      // Step 3: Delete from personnel table (parent table)
      $query_personnel_delete = $conn->prepare("DELETE FROM personnel WHERE Emp_No = ?");
      $query_personnel_delete->bind_param("s", $emp_no);
      if (!$query_personnel_delete->execute()) {
          throw new Exception("Failed to delete from personnel: " . $query_personnel_delete->error);
      }

      // Commit transaction
      $conn->commit();

      echo "<div class='alert alert-success'>Profile deleted successfully!</div>";
      echo "<script>window.location.href='/src/components/manage_regEmp.php';</script>"; // Redirect to manage personnel page
      exit();
  } catch (Exception $e) {
      // Rollback transaction on error
      $conn->rollback();
      echo "<div class='alert alert-danger'>Failed to delete the profile: " . $e->getMessage() . "</div>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
    .information-details p, .personnel-details p {
      margin-bottom: 5px; /* Decrease the space between <p> tags */
    }
    .text-muted {
        margin: 0px;
    }
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
            <h5 class="mt-2"><?php echo $employee['full_name']; ?></h5>
            <p class="text-muted"><i><?php echo $employee['Emp_No']; ?></i></p>
            <p class="text-muted" style="text-align: center;">
              <span class="badge" style="font-size: 14px; color: <?php echo $employee['emp_status'] === 'active' ? 'red' : 'green'; ?>;">
                  <i class="fas fa-circle" style="margin-right: 5px;"></i>
                  <?php echo ucfirst($employee['emp_status']); ?>
              </span>

              <?php
              // Define colors for each employee type
              $emp_type_colors = [
                  'regular' => 'blue',
                  'job_order' => 'green',
                  'contract' => 'yellow',
                  'intern' => 'red'
              ];

              // Get the color based on the employee type, default to gray if type is unknown
              $emp_type_color = $emp_type_colors[strtolower($employee['emp_type'])] ?? 'gray';
              ?>
              <span style="color: #6c757d; margin: 0 10px;">|</span>

              <span style="font-size: 14px; color: <?php echo $emp_type_colors[strtolower($employee['emp_type'])] ?? 'gray'; ?>;">
                  <i class="fas fa-user" style="margin-right: 5px;"></i>
                  <?php echo ucfirst($employee['emp_type']); ?>
              </span>
            </p>
            
            <hr>
            <p style="text-align: justify;"><i class="fas fa-map-marker-alt"></i> <?php echo $employee['address']; ?> &nbsp;</p>
            <p style="text-align: justify;"><i class="fas fa-phone"></i> <?php echo $employee['contact_number']; ?></p>
          </div>
        </div>

        <div class="col-md-9">
          <div class="card p-3 profile-card">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mt-3 mb-0">Personnel Information Details</h5>
            <div class="btn-container">
                <a href="javascript:history.back()" class="btn btn-secondary btn-sm">Back</a>
                <a href="/src/components/edit_regular.php?Emp_No=<?php echo $employee['Emp_No']; ?>" class="btn btn-success btn-sm">Update</a>
                <a href="?Emp_No=<?php echo urlencode($employee['Emp_No']); ?>&action=delete" class="btn btn-danger btn-sm">Delete</a>
                <a href="javascript:window.print()" class="btn btn-warning btn-sm">Print</a>
            </div>
        </div>

            <!-- Salary Information (Always shown) -->
            <div class="information-details row mt-3">
              <div class="col-md-6">
              <p><strong>Sex:</strong> <?php echo $employee['sex']; ?></p>
              <p><strong>Birthdate:</strong> <?php echo $employee['birthdate']; ?></p>
              <p><strong>Plantilla Number:</strong> <?php echo $plantillaNo ?? 'N/A'; ?></p>
              <p><strong>Position:</strong> <?php echo $employee['position']; ?></p>
              <p><strong>Division:</strong> <?php echo $employee['division']; ?></p>
              </div>
              <div class="col-md-6">
              <p><strong>Salary Grade:</strong> <?php echo $salary['salaryGrade']; ?></p>
              <p><strong>Step:</strong> <?php echo $salary['step']; ?></p>
              <p><strong>Level:</strong> <?php echo $salary['level']; ?></p>
              <p><strong>Monthly Salary:</strong> <?php echo $salary['monthlySalary']; ?></p>
              <p><strong>ACA Pera:</strong> <?php echo $acaPera ?? 'N/A'; ?></p>
              </div>
              <div class="col-md-6">
              </div>
            </div>

            <hr>
            <?php include __DIR__ . '/service_record.php'; ?>
        </div>
      </div>
    </div>
  </div>  
  <script>
  function deleteProfile() {
    if (confirm("Are you sure you want to delete this profile? This action cannot be undone.")) {
        // Redirect to the delete_profile.php script with the Emp_No as a parameter
        window.location.href = "/src/components/delete_profile.php?Emp_No=<?php echo urlencode($employee['Emp_No']); ?>";
    }
  }
</script>
</div>
</body>
</html>