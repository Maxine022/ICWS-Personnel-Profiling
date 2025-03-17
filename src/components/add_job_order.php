<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Job Order Employee</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .form-container {
            max-width: 700px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
            position: relative;
        }
        .form-control {
            height: 40px;
            background-color: #F5F5F5;
        }
        textarea.form-control {
            height: 100px;
            background-color: #F5F5F5; 
        }
        .dropdown-icon {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            pointer-events: none;
            font-size: 16px;
            color: #6c757d;
        }
        .btn-submit {
            font-size: 16px;
            padding: 8px 20px;
            width: 150px;
        }
        .form-title {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h3 class="text-center form-title">Add New Job Order Employee</h3>
            <form>
                <div class="form-group">
                    <label for="full-name">Full Name</label>
                    <input type="text" class="form-control" id="full-name" placeholder="Enter Full Name">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="birthdate">Birthdate</label>
                            <input type="date" class="form-control" id="birthdate">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sex">Sex</label>
                            <select class="form-control" id="sex">
                                <option>Select</option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="designation">Designation</label>
                            <div class="position-relative">
                                <select class="form-control" id="designation">
                                    <option>Enter Designation</option>
                                    <option>Designation 1</option>
                                    <option>Designation 2</option>
                                </select>
                                <i class="fa fa-angle-down dropdown-icon"></i> <!-- Dropdown Icon -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="salary-grade">Salary Grade</label>
                            <input type="text" class="form-control" id="salary-grade" placeholder="Enter Salary Grade">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" placeholder="Enter Address">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="time">Time</label>
                            <input type="time" class="form-control" id="time">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="total-hours">Total Number of Hours</label>
                            <input type="number" class="form-control" id="total-hours" placeholder="Enter Total Hours">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="justification">Justification of Activity</label>
                    <textarea class="form-control" id="justification" placeholder="Enter Justification"></textarea>
                </div>
                <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <textarea class="form-control" id="remarks" placeholder="Enter Remarks"></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
