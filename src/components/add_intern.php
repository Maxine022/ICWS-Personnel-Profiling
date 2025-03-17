<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Intern</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
        }
        .form-container {
            max-width: 750px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-control {
            height: 38px;
        }
        .btn-submit {
            font-size: 16px;
            padding: 8px 20px;
        }
        .input-group-text {
            background: #fff;
            border-left: 0;
        }
        .input-group .form-control {
            border-right: 0;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="form-container">
        <h3 class="text-center fw-bold">Add Intern</h3>
            <form>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="full-name">Full Name</label>
                            <input type="text" class="form-control" id="full-name" placeholder="Enter your Full Name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact-number">Contact Number</label>
                            <input type="text" class="form-control" id="contact-number" placeholder="Enter Contact Number">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="school">School</label>
                    <input type="text" class="form-control" id="school" placeholder="Enter School Name">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="course-program">Course/Program</label>
                            <input type="text" class="form-control" id="course-program" placeholder="Enter Course or Program">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="num-hours">Number of Hours</label>
                            <input type="text" class="form-control" id="num-hours" placeholder="Enter Number of Hours">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="internship-start">Internship Start Date</label>
                            <input type="date" class="form-control" id="internship-start">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="internship-end">Internship End Date</label>
                            <input type="date" class="form-control" id="internship-end">
                        </div>
                    </div>
                </div>

                <!-- Assigned Division with Dropdown Icon -->
                <div class="form-group">
                    <label for="assigned-division">Assigned Division</label>
                    <div class="input-group">
                        <select class="form-control" id="assigned-division">
                            <option>Please Select</option>
                            <option>Division 1</option>
                            <option>Division 2</option>
                            <option>Division 3</option>
                        </select>
                        <span class="input-group-text"><i class="fas fa-caret-down"></i></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="supervisor-name">Supervisor Name</label>
                    <input type="text" class="form-control" id="supervisor-name" placeholder="Enter Name">
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