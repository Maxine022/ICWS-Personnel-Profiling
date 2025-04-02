<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PWD Application Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 900px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

    <div class="container mt-4">
        <h2 class="text-center text-primary">PWD Application Form</h2>
        <form action="process_form.php" method="POST" enctype="multipart/form-data">
            
            <!-- Applicant Type -->
            <div class="mb-3">
                <label class="form-label">Applicant Type</label><br>
                <input type="radio" name="applicant_type" value="new" required> New Applicant
                <input type="radio" name="applicant_type" value="renewal"> Renewal
            </div>

            <!-- Personal Information -->
            <h4 class="text-primary">Personal Information</h4>
            <div class="row">
                <div class="col-md-6">
                    <label>Last Name</label>
                    <input type="text" name="last_name" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>First Name</label>
                    <input type="text" name="first_name" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Middle Name</label>
                    <input type="text" name="middle_name" class="form-control">
                </div>
                <div class="col-md-6">
                    <label>Suffix</label>
                    <input type="text" name="suffix" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label>Date of Birth</label>
                    <input type="date" name="dob" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Sex</label><br>
                    <input type="radio" name="sex" value="male" required> Male
                    <input type="radio" name="sex" value="female"> Female
                </div>
            </div>

            <!-- Address -->
            <h4 class="text-primary">Address</h4>
            <div class="row">
                <div class="col-md-6">
                    <label>House No. & Street</label>
                    <input type="text" name="address" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Barangay</label>
                    <input type="text" name="barangay" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Municipality</label>
                    <input type="text" name="municipality" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Province</label>
                    <input type="text" name="province" class="form-control" required>
                </div>
            </div>

            <!-- Contact Information -->
            <h4 class="text-primary">Contact Details</h4>
            <div class="row">
                <div class="col-md-6">
                    <label>Mobile No.</label>
                    <input type="text" name="mobile" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control">
                </div>
            </div>

            <!-- Type of Disability -->
            <h4 class="text-primary">Type of Disability</h4>
            <div class="mb-3">
                <input type="checkbox" name="disability[]" value="deaf"> Deaf or Hard of Hearing
                <input type="checkbox" name="disability[]" value="intellectual"> Intellectual Disability
                <input type="checkbox" name="disability[]" value="visual"> Visual Disability
                <input type="checkbox" name="disability[]" value="psychosocial"> Psychosocial Disability
                <input type="checkbox" name="disability[]" value="others"> Others (Specify)
                <input type="text" name="other_disability" class="form-control">
            </div>

            <!-- Education & Occupation -->
            <h4 class="text-primary">Education & Employment</h4>
            <div class="row">
                <div class="col-md-6">
                    <label>Educational Attainment</label>
                    <select name="education" class="form-control">
                        <option value="none">None</option>
                        <option value="elementary">Elementary</option>
                        <option value="highschool">High School</option>
                        <option value="college">College</option>
                        <option value="vocational">Vocational</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Employment Status</label>
                    <select name="employment_status" class="form-control">
                        <option value="employed">Employed</option>
                        <option value="unemployed">Unemployed</option>
                        <option value="self-employed">Self-Employed</option>
                    </select>
                </div>
            </div>

            <!-- Emergency Contact -->
            <h4 class="text-primary">Emergency Contact</h4>
            <div class="row">
                <div class="col-md-6">
                    <label>Contact Person's Name</label>
                    <input type="text" name="emergency_name" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Contact Person's No.</label>
                    <input type="text" name="emergency_contact" class="form-control" required>
                </div>
            </div>

            <!-- File Upload -->
            <h4 class="text-primary">Upload Required Documents</h4>
            <div class="mb-3">
                <label>Upload 1x1 Photo:</label>
                <input type="file" name="photo" class="form-control">
            </div>

            <!-- Buttons -->
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>

        </form>
    </div>

</body>
</html>