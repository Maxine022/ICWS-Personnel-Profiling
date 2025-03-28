<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PWD Application Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f5f6fa;
      font-family: 'Segoe UI', sans-serif;
    }
    .form-container {
      background: #fff;
      border-radius: 10px;
      padding: 30px;
      margin-top: 30px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      position: relative;
    }
    .section-title {
      font-size: 1.25rem;
      font-weight: 600;
      margin-top: 30px;
      margin-bottom: 15px;
      color: #0d6efd;
      border-left: 5px solid #0d6efd;
      padding-left: 10px;
    }
    label {
      font-weight: 500;
    }
    .photo-upload {
        position: absolute;
        top: 30px;
        right: 30px;
        width: 120px;
        height: 120px;
        border: 2px dashed #0d6efd;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        text-align: center;
        background-color: #f0f8ff;
        font-size: 12px;
        color: #0d6efd;
        cursor: pointer;
        overflow: hidden;
    }

    .photo-upload img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 10px;
    }

    .photo-upload input[type="file"] {
        display: none;
    }

    #photoText {
        padding: 0 5px;
    }
  </style>
</head>
<body>
<div class="container">
  <div class="form-container">
    <h2 class="text-center text-primary">PWD Application Form</h2>
    <div class="photo-upload" onclick="document.getElementById('photoInput').click()">
      <input type="file" id="photoInput" accept="image/*" onchange="previewPhoto(event)">
      <span id="photoText">Upload<br>1x1 Photo</span>
      <img id="photoPreview" src="#" alt="" style="display:none;" />
    </div>

    <form id="pwdForm">

      <div class="section-title">Application Details</div>
      <div class="row mb-3">
        <div class="col-md-4">
          <label>Application Type *</label><br>
          <input type="radio" name="applicant_type" value="New Applicant"> New Applicant
          <input type="radio" name="applicant_type" value="Renewal"> Renewal
        </div>
        <div class="col-md-4">
          <label>PWD Number</label>
          <input type="text" class="form-control" placeholder="RR-PPMM-BBB-NNNNNNN">
        </div>
        <div class="col-md-4">
          <label>Date Applied *</label>
          <input type="date" class="form-control">
        </div>
      </div>

      <div class="section-title">Personal Information</div>
      <div class="row mb-3">
        <div class="col-md-3"><label>Last Name *</label><input type="text" class="form-control"></div>
        <div class="col-md-3"><label>First Name *</label><input type="text" class="form-control"></div>
        <div class="col-md-3"><label>Middle Name</label><input type="text" class="form-control"></div>
        <div class="col-md-3"><label>Suffix</label><input type="text" class="form-control"></div>
        <div class="col-md-4"><label>Date of Birth *</label><input type="date" class="form-control"></div>
        <div class="col-md-4"><label>Sex *</label><select class="form-select"><option>Male</option><option>Female</option></select></div>
        <div class="col-md-4"><label>Civil Status *</label><select class="form-select"><option>Single</option><option>Separated</option><option>Cohabitation</option><option>Married</option><option>Widow/er</option></select></div>
      </div>

      <div class="section-title">Type and Cause of Disability</div>
      <div class="row mb-3">
        <div class="col-md-6">
          <label>Type of Disability</label>
          <div class="form-check"><input type="checkbox" class="form-check-input"> Deaf or Hard of Hearing</div>
          <div class="form-check"><input type="checkbox" class="form-check-input"> Intellectual Disability</div>
          <div class="form-check"><input type="checkbox" class="form-check-input"> Learning Disability</div>
          <div class="form-check"><input type="checkbox" class="form-check-input"> Mental Disability</div>
          <div class="form-check"><input type="checkbox" class="form-check-input"> Physical Disability (Orthopedic)</div>
          <div class="form-check"><input type="checkbox" class="form-check-input"> Psychosocial Disability</div>
          <div class="form-check"><input type="checkbox" class="form-check-input"> Speech and Language Impairment</div>
          <div class="form-check"><input type="checkbox" class="form-check-input"> Visual Disability</div>
          <div class="form-check"><input type="checkbox" class="form-check-input"> Cancer (RA 11215)</div>
          <div class="form-check"><input type="checkbox" class="form-check-input"> Rare Disease (RA 10747)</div>
          <div class="form-check"><input type="checkbox" class="form-check-input"> Others (specify)</div>
        </div>
        <div class="col-md-6">
          <label>Cause of Disability</label>
          <div class="form-check"><input type="checkbox" class="form-check-input"> Congenital/Inborn</div>
          <div class="form-check"><input type="checkbox" class="form-check-input"> Acquired</div>
          <div class="form-check"><input type="checkbox" class="form-check-input"> ADHD</div>
          <div class="form-check"><input type="checkbox" class="form-check-input"> Chronic Illness</div>
          <div class="form-check"><input type="checkbox" class="form-check-input"> Cerebral Palsy</div>
          <div class="form-check"><input type="checkbox" class="form-check-input"> Down Syndrome</div>
          <div class="form-check"><input type="checkbox" class="form-check-input"> Injury</div>
          <div class="form-check"><input type="checkbox" class="form-check-input"> Others (specify)</div>
        </div>
      </div>

      <div class="section-title">Residence Address</div>
      <div class="row mb-3">
        <div class="col-md-3"><label>House No. & Street</label><input type="text" class="form-control"></div>
        <div class="col-md-3"><label>Barangay</label><input type="text" class="form-control"></div>
        <div class="col-md-3"><label>Municipality</label><input type="text" class="form-control"></div>
        <div class="col-md-3"><label>Province</label><input type="text" class="form-control"></div>
        <div class="col-md-3"><label>Region</label><input type="text" class="form-control"></div>
      </div>

      <div class="section-title">Contact Details</div>
      <div class="row mb-3">
        <div class="col-md-4"><label>Landline</label><input type="text" class="form-control"></div>
        <div class="col-md-4"><label>Mobile</label><input type="text" class="form-control"></div>
        <div class="col-md-4"><label>Email</label><input type="email" class="form-control"></div>
      </div>

      <div class="section-title">Education & Employment</div>
      <div class="row mb-3">
        <div class="col-md-4"><label>Educational Attainment</label><select class="form-select">
          <option>None</option><option>Kindergarten</option><option>Elementary</option><option>Junior High</option><option>Senior High</option><option>College</option><option>Vocational</option><option>Post Graduate</option></select></div>
        <div class="col-md-4"><label>Employment Status</label><select class="form-select"><option>Employed</option><option>Unemployed</option><option>Self-Employed</option></select></div>
        <div class="col-md-4"><label>Type of Employment</label><select class="form-select"><option>Permanent/Regular</option><option>Seasonal</option><option>Casual</option><option>Emergency</option></select></div>
      </div>

      <div class="row mb-3">
        <div class="col-md-4"><label>Category</label><select class="form-select"><option>Government</option><option>Private</option></select></div>
        <div class="col-md-4"><label>Occupation</label><input type="text" class="form-control"></div>
      </div>

      <div class="section-title">Organization Information</div>
      <div class="row mb-3">
        <div class="col-md-4"><label>Organization Affiliated</label><input type="text" class="form-control"></div>
        <div class="col-md-4"><label>Contact Person</label><input type="text" class="form-control"></div>
        <div class="col-md-4"><label>Office Address</label><input type="text" class="form-control"></div>
      </div>

      <div class="section-title">Government IDs</div>
      <div class="row mb-3">
        <div class="col-md-3"><label>SSS No.</label><input type="text" class="form-control"></div>
        <div class="col-md-3"><label>GSIS No.</label><input type="text" class="form-control"></div>
        <div class="col-md-3"><label>Pag-IBIG No.</label><input type="text" class="form-control"></div>
        <div class="col-md-3"><label>PhilHealth No.</label><input type="text" class="form-control"></div>
      </div>

      <div class="section-title">Family Background</div>
      <div class="row mb-3">
        <div class="col-md-4"><label>Father's Name</label><input type="text" class="form-control"></div>
        <div class="col-md-4"><label>Mother's Name</label><input type="text" class="form-control"></div>
        <div class="col-md-4"><label>Guardian's Name</label><input type="text" class="form-control"></div>
      </div>

      <div class="section-title">Accomplished By</div>
      <div class="mb-3">
        <input type="radio" name="accomplished_by" value="Applicant"> Applicant
        <input type="radio" name="accomplished_by" value="Guardian"> Guardian
        <input type="radio" name="accomplished_by" value="Representative"> Representative
      </div>

      <div class="section-title">Certifications</div>
      <div class="row mb-3">
        <div class="col-md-4"><label>Certifying Physician</label><input type="text" class="form-control"></div>
        <div class="col-md-4"><label>License No</label><input type="text" class="form-control"></div>
        <div class="col-md-4"><label>Processing Officer</label><input type="text" class="form-control"></div>
        <div class="col-md-4"><label>Approving Officer</label><input type="text" class="form-control"></div>
        <div class="col-md-4"><label>Encoder</label><input type="text" class="form-control"></div>
        <div class="col-md-4"><label>Reporting Unit</label><input type="text" class="form-control"></div>
        <div class="col-md-4"><label>Control No</label><input type="text" class="form-control"></div>
      </div>

      <div class="section-title">Emergency Contact</div>
      <div class="row mb-3">
        <div class="col-md-6"><label>Contact Person Name</label><input type="text" class="form-control"></div>
        <div class="col-md-6"><label>Contact No.</label><input type="text" class="form-control"></div>
      </div>

      <div class="text-end mt-4">
        <button class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-outline-secondary">Reset</button>
      </div>
    </form>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function previewPhoto(event) {
    const input = event.target;
    const preview = document.getElementById('photoPreview');
    const text = document.getElementById('photoText');

    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        preview.src = e.target.result;
        preview.style.display = 'block';
        text.style.display = 'none';
      };
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>
</body>
</html>