<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Regular Employee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            background: #2C3E50;
            padding-top: 20px;
        }
        .sidebar a {
            padding: 15px;
            text-decoration: none;
            font-size: 16px;
            color: white;
            display: block;
        }
        .sidebar a:hover {
            background: #1A252F;
        }
        .active {
            background: #1A252F;
        }
        .content {
            margin-left: 260px;
            padding: 20px;
        }
        .form-control {
            height: 42px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center text-white">ICWS</h4>
        <a href="#"><i class="fa-solid fa-user"></i> Profile</a>
        <a href="#"><i class="fa-solid fa-users"></i> Personnel</a>
        <a href="#" class="active"><i class="fa-solid fa-user-gear"></i> Manage Personnel</a>
        <a href="#"><i class="fa-solid fa-sign-out-alt"></i> Logout</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>Add New Regular Employee</h3>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Manage</a></li>
                        <li class="breadcrumb-item active">Add New Regular Employee</li>
                    </ol>
                </nav>
            </div>

            <form>
                <div class="row">
                    <!-- Full Name -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" placeholder="Enter Full Name">
                    </div>
                    
                    <!-- Position -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Position</label>
                        <select class="form-control">
                            <option>Choose Position</option>
                            <option>Manager</option>
                            <option>Assistant</option>
                        </select>
                    </div>

                    <!-- Division -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Division</label>
                        <select class="form-control">
                            <option>Choose Division</option>
                            <option>IT Department</option>
                            <option>HR Department</option>
                        </select>
                    </div>

                    <!-- Plantilla Number -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Plantilla Number</label>
                        <input type="text" class="form-control" placeholder="Enter Plantilla Number">
                    </div>

                    <!-- Monthly Salary -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Monthly Salary</label>
                        <input type="text" class="form-control" placeholder="Enter Monthly Salary">
                    </div>

                    <!-- Salary Grade, Step, Level -->
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Salary Grade</label>
                        <input type="text" class="form-control" placeholder="Grade">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Step</label>
                        <input type="text" class="form-control" placeholder="Step">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Level</label>
                        <input type="text" class="form-control" placeholder="Level">
                    </div>

                    <!-- ACA Pera -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">ACA Pera</label>
                        <input type="text" class="form-control" placeholder="Enter ACA Pera">
                    </div>

                    <!-- RAT Plan Assignment -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">RAT Plan Assignment</label>
                        <input type="text" class="form-control" placeholder="Enter Assignment">
                    </div>

                    <!-- Contact Number (Newly Added) -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Contact Number</label>
                        <input type="text" class="form-control" placeholder="Enter Contact Number">
                    </div>

                </div>

                <!-- Buttons -->
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary px-4">Submit</button>
                    <button type="button" class="btn btn-light px-4">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
