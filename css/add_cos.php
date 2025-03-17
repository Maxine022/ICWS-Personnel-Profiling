<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Contract of Service</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-control {
            height: 38px;
        }
        textarea.form-control {
            height: 80px;
        }
        .btn-submit {
            font-size: 14px;
            padding: 5px 15px;
        }
        .dropdown-toggle {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h3 class="text-center"><strong>Add Contract of Service</strong></h3>
            <form>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter Full Name">
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" placeholder="Enter Address">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact-number">Contact Number</label>
                            <input type="text" class="form-control" id="contact-number" placeholder="Enter Contact Number">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="birthdate">Birthdate</label>
                            <input type="date" class="form-control" id="birthdate">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sex">Sex</label>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="sexDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span id="sexSelected">Please Select</span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="sexDropdown">
                                    <li><a class="dropdown-item sex-option" href="#">Male</a></li>
                                    <li><a class="dropdown-item sex-option" href="#">Female</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="designation">Designation</label>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="designationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span id="designationSelected">Please Select</span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="designationDropdown">
                                    <li><a class="dropdown-item designation-option" href="#">Designation 1</a></li>
                                    <li><a class="dropdown-item designation-option" href="#">Designation 2</a></li>
                                    <li><a class="dropdown-item designation-option" href="#">Designation 3</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="salary-rate">Salary Rate</label>
                            <input type="text" class="form-control" id="salary-rate" placeholder="Enter Salary Rate">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="years-service">Years in Service</label>
                            <input type="number" class="form-control" id="years-service" placeholder="Enter Years in Service">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contract-start">Contract Duration - Start</label>
                            <input type="date" class="form-control" id="contract-start">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contract-end">Contract Duration - End</label>
                            <input type="date" class="form-control" id="contract-end">
                        </div>
                    </div>
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
    <script>
        document.querySelectorAll(".sex-option").forEach(item => {
            item.addEventListener("click", function() {
                document.getElementById("sexSelected").textContent = this.textContent;
            });
        });

        document.querySelectorAll(".designation-option").forEach(item => {
            item.addEventListener("click", function() {
                document.getElementById("designationSelected").textContent = this.textContent;
            });
        });
    </script>
</body>
</html>
