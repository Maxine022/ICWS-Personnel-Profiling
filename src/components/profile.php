<?php
session_start();
include_once __DIR__ . '/../../backend/db.php'; // Path to your db connection file

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

// Query to get reg_emp details
$query_reg_emp = $conn->prepare("SELECT * FROM reg_emp WHERE personnel_id = ?");
$query_reg_emp->bind_param("i", $employee['personnel_id']);
$query_reg_emp->execute();
$reg_emp_result = $query_reg_emp->get_result();
$reg_emp = $reg_emp_result->fetch_assoc() ?: [];

// Access plantillaNo and acaPera
$plantillaNo = $reg_emp['plantillaNo'] ?? null;
$acaPera = $reg_emp['acaPera'] ?? null;

// Query to get job order details
$query_job_order = $conn->prepare("SELECT * FROM job_order WHERE personnel_id = ?");
$query_job_order->bind_param("i", $employee['personnel_id']);
$query_job_order->execute();
$job_order_result = $query_job_order->get_result();
$job_order = $job_order_result->fetch_assoc() ?: [];

// Query to get contract details
$query_cos = $conn->prepare("SELECT * FROM contract_service WHERE personnel_id = ?");
$query_cos->bind_param("i", $employee['personnel_id']);
$query_cos->execute();
$contracts_result = $query_cos->get_result();
$contract_service = $contracts_result->fetch_assoc() ?: [];

// Determine employment type
$employment_type = '';
if (!empty($reg_emp['plantillaNo'])) {
    $employment_type = 'regular';
} elseif (!empty($job_order['salaryRate'])) {
    $employment_type = 'job_order';
} elseif (!empty($contract_service['contract_status'])) {
    $employment_type = 'contract';
}

// Normalize emp_type for logic and display
$emp_type = strtolower(str_replace(' ', '_', $employee['emp_type'] ?? $employment_type ?? 'unknown'));

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
        $query_reg_emp = $conn->prepare("DELETE FROM reg_emp WHERE personnel_id = ?");
        $query_reg_emp->bind_param("i", $personnel_id);
        $query_reg_emp->execute();

        $query_salary = $conn->prepare("DELETE FROM salary WHERE personnel_id = ?");
        $query_salary->bind_param("i", $personnel_id);
        $query_salary->execute();

        $query_personnel_delete = $conn->prepare("DELETE FROM personnel WHERE Emp_No = ?");
        $query_personnel_delete->bind_param("s", $emp_no);
        $query_personnel_delete->execute();

        // Commit transaction
        $conn->commit();

        echo "<div class='alert alert-success'>Profile deleted successfully!</div>";
        echo "<script>window.location.href='/src/components/manage_regEmp.php';</script>";
        exit();
    } catch (Exception $e) {
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
            <span class="badge" style="font-size: 14px; padding: 5px 10px; border-radius: 12px; display: inline-flex; align-items: center; font-weight: bold; color: white; background-color: <?php echo strtolower($employee['emp_status']) === 'active' ? 'green' : 'red'; ?>; border: 1px solid <?php echo strtolower($employee['emp_status']) === 'active' ? 'green' : 'red'; ?>;">
                  <i class="fas fa-circle" style="margin-right: 5px; font-size: 10px;"></i>
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
              $emp_type_color = $emp_type_colors[$emp_type] ?? 'gray';
              ?>
              <span style="color: #6c757d; margin: 0 10px;">|</span>

              <span style="font-size: 14px; color: <?php echo $emp_type_color; ?>;">
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
                <a href="<?php 
                    if ($emp_type === 'regular') {
                        echo '/src/components/edit_regular.php?Emp_No=' . urlencode($employee['Emp_No']);
                    } elseif ($emp_type === 'job_order') {
                        echo '/src/components/edit_jo.php?Emp_No=' . urlencode($employee['Emp_No']);
                    } elseif ($emp_type === 'contract') {
                        echo '/src/components/edit_cos.php?Emp_No=' . urlencode($employee['Emp_No']);
                    } else {
                        echo 'javascript:void(0);'; // Default action if emp_type is unknown
                    }
                ?>" class="btn btn-success btn-sm">Update</a>
                <a href="?Emp_No=<?php echo urlencode($employee['Emp_No']); ?>&action=delete" class="btn btn-danger btn-sm">Delete</a>
                <a href="/src/components/print_profile.php?Emp_No=<?= urlencode($employee['Emp_No']) ?>" target="_blank" class="btn btn-warning btn-sm">Print</a>
            </div>
        </div>

            <!-- Salary Information (Always shown) -->
            <div class="information-details row mt-3">
              <div class="col-md-6">
              <p><strong>Sex:</strong> <?php echo $employee['sex']; ?></p>
              <p><strong>Birthdate:</strong> <?php echo $employee['birthdate']; ?></p>
              <p><strong>Position:</strong> <?php echo $employee['position']; ?></p>
              <p><strong>Division:</strong> <?php echo $employee['division']; ?></p>
              </div>
              <div class="col-md-6">
              <?php if ($emp_type === 'regular'): ?>
                <p><strong>Plantilla Number:</strong> <?php echo $plantillaNo ?? 'N/A'; ?></p>
                <p><strong>Salary Grade:</strong> <?php echo $salary['salaryGrade']; ?></p>
                <p><strong>Step:</strong> <?php echo $salary['step']; ?></p>
                <p><strong>Level:</strong> <?php echo $salary['level']; ?></p>
                <p><strong>Monthly Salary:</strong> <?php echo $salary['monthlySalary']; ?></p>
                <p><strong>ACA Pera:</strong> <?php echo $acaPera ?? 'N/A'; ?></p>
              <?php elseif ($emp_type === 'job_order'): ?>
                <p><strong>Salary Rate:</strong> <?php echo $job_order['salaryRate'] ?? 'N/A'; ?></p>
              <?php elseif ($emp_type === 'contract'): ?>
                  <p><strong>Salary Rate:</strong> <?php echo $contract['salaryRate'] ?? 'N/A'; ?></p>
              <?php endif; ?>
            </div>
              <div class="col-md-6">
              </div>
            </div>

            <hr>
            <?php
                // Set visibility flags based on emp_type
                $show_service_record = false;
                $show_service_contract = false;
                $show_contract_record = false;

                if ($emp_type === 'regular') {
                    $show_service_record = true;
                } elseif ($emp_type === 'job_order') {
                    $show_service_contract = true;
                } elseif ($emp_type === 'contract') {
                    $show_contract_record = true;
                }
            ?>

          <!-- Display the appropriate section based on the parameters -->
          <?php if ($show_service_record): ?>
              <?php 
              $service_record_path = __DIR__ . '/service_record.php';
              if (file_exists($service_record_path)) {
                  include $service_record_path; 
              } else {
                  echo "<p>Error: service_record.php not found.</p>";
              }
              ?>
          <?php endif; ?>

          <?php if ($show_service_contract): ?>
              <?php 
              $service_contract_path = __DIR__ . '/service_contract.php';
              if (file_exists($service_contract_path)) {
                  include $service_contract_path; 
              } else {
                  echo "<p>Error: service_contract.php not found.</p>";
              }
              ?>
          <?php endif; ?>

          <?php if ($show_contract_record): ?>
              <?php 
              $contract_record_path = __DIR__ . '/service_contractRecord.php';
              if (file_exists($contract_record_path)) {
                  include $contract_record_path; 
              } else {
                  echo "<p>Error: service_contractRecord.php not found.</p>";
              }
              ?>
          <?php endif; ?>
          <?php echo "<!-- emp_type: $emp_type | employee[emp_type]: " . ($employee['emp_type'] ?? 'NOT SET') . " | employment_type: $employment_type -->"; ?>
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