<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Colorful Arrow Flowchart</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f6f8;
      padding: 50px;
      text-align: center;
    }

    h2 {
      color: #333;
      margin-bottom: 30px;
    }

    .flow-container {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 10px;
    }

    .arrow {
      position: relative;
      color: white;
      padding: 20px 50px 20px 40px;
      font-weight: bold;
      font-size: 16px;
      clip-path: polygon(0 0, calc(100% - 20px) 0, 100% 50%, calc(100% - 20px) 100%, 0 100%, 20px 50%);
      z-index: 1;
      min-width: 180px;
      text-align: center;
    }

    .arrow:nth-child(1) {
      background: #6C63FF; /* Soft Indigo */
    }

    .arrow:nth-child(2) {
      background: #00B4D8; /* Sky Blue */
    }

    .arrow:nth-child(3) {
      background: #F3722C; /* Orange */
    }

    .arrow:nth-child(4) {
      background: #43AA8B; /* Teal Green */
    }

    .arrow-label {
      font-size: 13px;
      color: #333;
      margin-top: 10px;
    }
  </style>
</head>
<body>

  <h2>Simple Process Flow Diagram</h2>

  <div class="flow-container">
    <div>
      <div class="arrow">Step 1<br>Start Application</div>
      <div class="arrow-label">This is a sample text.</div>
    </div>
    <div>
      <div class="arrow">Step 2<br>Fill Personal Info</div>
      <div class="arrow-label">This is a sample text.</div>
    </div>
    <div>
      <div class="arrow">Step 3<br>Upload Photo</div>
      <div class="arrow-label">This is a sample text.</div>
    </div>
    <div>
      <div class="arrow">Step 4<br>Submit Form</div>
      <div class="arrow-label">This is a sample text.</div>
    </div>
  </div>

</body>
</html>
