<?php 

include_once __DIR__ . '/../../backend/db.php';

// Fetch the full_name, birthdate and division from personnel table
$personnel = [];
$sql = "SELECT full_name, birthdate, division, profile_picture, personnel_id 
        FROM personnel 
        WHERE emp_status = 'Active' 
        ORDER BY MONTH(birthdate) DESC, DAY(birthdate) ASC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $personnel[] = $row;
    }
} else {
    $error = $conn->error ? "Database Error: {$conn->error}" : "No personnel found.";
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1, width=device-width">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" />
<style>
body {
    background: #f4f6fa;
    font-family: 'Poppins', sans-serif;
}
.birthday-announcement {
    max-width: 1500px;
    margin: 40px auto;
    background: rgba(42, 22, 111, 0.10);
    border-radius: 25px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.10);
    padding: 32px 24px 24px 24px;
    position: relative;
}
#monthLabel {
    font-size: 1.3rem;
    font-weight: 600;
    color: #2a166f;
    letter-spacing: 1px;
}
.profile-pic-icon {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #2a166f;
    background: #fff;
}
.celebrant-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2a166f;
}
.celebrant-division {
    font-size: 0.95rem;
    color: #555;
    margin-bottom: 4px;
}
.celebrant-date {
    font-size: 0.98rem;
    color: #7c3aed;
    font-weight: 500;
}
.toast {
    z-index: 1050;
    animation: fadeIn 0.5s, fadeOut 0.5s 3s;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes fadeOut {
    from { opacity: 1; }
    to { opacity: 0; }
}
</style>
</head>
<body>
<div class="birthday-announcement position-relative">
    <button class="btn btn-primary position-absolute top-0 end-0 m-3"
        onclick="downloadCelebrantNames()">
        Download Names
    </button>
    <div class="d-flex align-items-center justify-content-center gap-3 mb-4">
        <button id="prevMonth" class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center" type="button">
            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M16.5 20L10.5 14L16.5 8" stroke="#2a166f" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
        <span id="monthLabel" class="text-nowrap">BIRTHDAY CELEBRANTS</span>
        <button id="nextMonth" class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center" type="button">
            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">	
                <path d="M11.5 8L17.5 14L11.5 20" stroke="#2a166f" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
		
    </div>
    <?php if (!empty($error)): ?>
        <div class="alert alert-warning text-center"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
	<?php if (empty($personnel)): ?>
		<div class="alert alert-info text-center">No birthday celebrants found for this month.</div>
	<?php endif; ?>

    <!-- Cards -->
    <div class="row g-3 justify-content-center" id="celebrantsList">
        <?php foreach ($personnel as $person): 
            $monthNum = date('n', strtotime($person['birthdate'])) - 1; // 0-based for JS
            $day = date('j', strtotime($person['birthdate']));
            $month = date('F', strtotime($person['birthdate']));

            $uploadDir = __DIR__ . '/../../uploads/';
            $webUploadDir = '../../uploads/';
            $defaultPic = '../../assets/profile.jpg';

            $profilePicBase = 'profile_' . $person['personnel_id'];
            $profilePicPathJpg = $uploadDir . $profilePicBase . '.jpg';
            $profilePicPathPng = $uploadDir . $profilePicBase . '.png';
            $profilePicWebJpg = $webUploadDir . $profilePicBase . '.jpg';
            $profilePicWebPng = $webUploadDir . $profilePicBase . '.png';

            if (file_exists($profilePicPathJpg)) {
                $profilePic = $profilePicWebJpg;
            } elseif (file_exists($profilePicPathPng)) {
                $profilePic = $profilePicWebPng;
            } else {
                $profilePic = $defaultPic;
            }
        ?>
        <div class="col-12 col-md-3 celebrant-card" data-month="<?php echo $monthNum; ?>">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <img class="profile-pic-icon" src="<?php echo htmlspecialchars($profilePic); ?>" alt="Profile">
                    <div>
                        <div class="celebrant-name"><?php echo htmlspecialchars($person['full_name']); ?></div>
                        <div class="celebrant-division"><?php echo htmlspecialchars($person['division']); ?></div>
                        <div class="celebrant-date"><?php echo $month . ' ' . $day; ?></div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<ul id="celebrantNamesList" style="display:none;">
    <?php foreach ($personnel as $person): 
        $monthNum = date('n', strtotime($person['birthdate'])) - 1;
    ?>
    <li class="celebrant-name-list" data-month="<?php echo $monthNum; ?>">
        <?php echo htmlspecialchars($person['full_name']); ?>
    </li>
    <?php endforeach; ?>
</ul>
<div id="toast" class="toast align-items-center text-bg-success border-0 position-fixed top-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true" style="display: none;">
    <div class="d-flex">
        <div class="toast-body">
            File downloaded successfully!
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" aria-label="Close" onclick="hideToast()"></button>
    </div>
</div>
<script>
const months = [
    "JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE",
    "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER"
];
let currentMonth = new Date().getMonth(); // Default to current month

function updateMonthLabel() {
    document.getElementById('monthLabel').textContent = months[currentMonth] + " BIRTHDAY CELEBRANTS";
}

function filterCelebrants() {
    document.querySelectorAll('.celebrant-card').forEach(card => {
        if (parseInt(card.getAttribute('data-month')) === currentMonth) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
    filterCelebrantNames();
}

function filterCelebrantNames() {
    document.querySelectorAll('.celebrant-name-list').forEach(item => {
        if (parseInt(item.getAttribute('data-month')) === currentMonth) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
}

document.getElementById('prevMonth').onclick = function() {
    currentMonth = (currentMonth - 1 + 12) % 12;
    updateMonthLabel();
    filterCelebrants();
};

document.getElementById('nextMonth').onclick = function() {
    currentMonth = (currentMonth + 1) % 12;
    updateMonthLabel();
    filterCelebrants();
};

// Initial display
updateMonthLabel();
filterCelebrants();

function downloadCelebrantNames() {
    const names = [];
    document.querySelectorAll('.celebrant-name-list').forEach(item => {
        if (parseInt(item.getAttribute('data-month')) === currentMonth) {
            names.push(item.textContent.trim());
        }
    });

    if (names.length === 0) {
        alert('No celebrants for this month.');
        return;
    }

    const header = `Birthday Celebrants for ${months[currentMonth]}\n\n`;
    const content = header + names.map((name, index) => `${index + 1}. ${name}`).join('\n');

    // Create a Blob for the file
    const blob = new Blob([content], { type: 'text/plain' });

    // Create a temporary link to trigger the download
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `${months[currentMonth]}_celebrants.txt`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);

    // Show toast notification
    showToast();
}

function showToast() {
    const toast = document.getElementById('toast');
    toast.style.display = 'block';
    setTimeout(() => {
        toast.style.display = 'none';
    }, 3500);
}

function hideToast() {
    document.getElementById('toast').style.display = 'none';
}
</script>
</body>
</html>