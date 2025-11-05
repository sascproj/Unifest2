<?php
include '../includes/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

// Get competitions for dropdown
$competitions = $pdo->query("SELECT * FROM competitions ORDER BY name")->fetchAll();

// Get participants for selected competition
$participants = [];
if (isset($_GET['competition_id'])) {
    $competition_id = $_GET['competition_id'];
    $stmt = $pdo->prepare("
        SELECT s.*, c.name as college_name 
        FROM students s 
        JOIN registrations r ON s.id = r.student_id 
        JOIN colleges c ON s.college_id = c.id 
        WHERE r.competition_id = ?
    ");
    $stmt->execute([$competition_id]);
    $participants = $stmt->fetchAll();
}

// Handle marks submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $competition_id = $_POST['competition_id'];
    $marks = $_POST['marks'];
    $judge_number = $_POST['judge_number'];
    
    $stmt = $pdo->prepare("INSERT INTO marks (student_id, competition_id, marks_obtained, judge_number) VALUES (?, ?, ?, ?)");
    $stmt->execute([$student_id, $competition_id, $marks, $judge_number]);
    
    header('Location: enter_marks.php?success=marks_added&competition_id=' . $competition_id);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Marks - UniFest 2026</title>
    <!-- Include CSS -->
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column">
        <!-- Your admin sidebar -->
        <a href="enter_marks.php" class="nav-link active"><i class="fas fa-marker me-2"></i>Enter Marks</a>
    </div>

    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-dark mb-4 rounded">
            <div class="container-fluid">
                <h4 class="text-white mb-0"><i class="fas fa-marker me-2"></i>Enter Marks</h4>
            </div>
        </nav>

        <!-- Competition Selection -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Select Competition</label>
                            <select name="competition_id" class="form-select" onchange="this.form.submit()">
                                <option value="">-- Select Competition --</option>
                                <?php foreach ($competitions as $comp): ?>
                                <option value="<?php echo $comp['id']; ?>" <?php echo isset($_GET['competition_id']) && $_GET['competition_id'] == $comp['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($comp['name']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Judge Number</label>
                            <select name="judge_number" class="form-select">
                                <option value="1">Judge 1</option>
                                <option value="2">Judge 2</option>
                                <option value="3">Judge 3</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <?php if (isset($_GET['competition_id'])): ?>
        <!-- Marks Entry Form -->
        <div class="card">
            <div class="card-header">
                <h5>Enter Marks for Participants</h5>
            </div>
            <div class="card-body">
                <?php if (empty($participants)): ?>
                    <p class="text-muted">No participants registered for this competition.</p>
                <?php else: ?>
                    <form method="POST">
                        <input type="hidden" name="competition_id" value="<?php echo $_GET['competition_id']; ?>">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Participant Name</th>
                                        <th>College</th>
                                        <th>Roll Number</th>
                                        <th>Marks (0-100)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($participants as $participant): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($participant['name']); ?></td>
                                        <td><?php echo htmlspecialchars($participant['college_name']); ?></td>
                                        <td><?php echo htmlspecialchars($participant['roll_number']); ?></td>
                                        <td style="width: 150px;">
                                            <input type="number" class="form-control" name="marks[<?php echo $participant['id']; ?>]" min="0" max="100" step="0.1" required>
                                        </td>
                                        <td>
                                            <button type="submit" name="student_id" value="<?php echo $participant['id']; ?>" class="btn btn-primary btn-sm">
                                                Save Marks
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
