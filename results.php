<?php
include 'includes/config.php';

// Get all competitions
$competitions = $pdo->query("SELECT * FROM competitions ORDER BY event_datetime")->fetchAll();

// Get results for selected competition
$results = [];
if (isset($_GET['competition_id'])) {
    $competition_id = $_GET['competition_id'];
    
    $stmt = $pdo->prepare("
        SELECT 
            s.name as student_name,
            s.roll_number,
            c.name as college_name,
            AVG(m.marks_obtained) as average_marks,
            COUNT(m.judge_number) as judges_count
        FROM students s
        JOIN colleges c ON s.college_id = c.id
        JOIN registrations r ON s.id = r.student_id
        LEFT JOIN marks m ON s.id = m.student_id AND m.competition_id = ?
        WHERE r.competition_id = ?
        GROUP BY s.id
        HAVING judges_count > 0
        ORDER BY average_marks DESC
    ");
    $stmt->execute([$competition_id, $competition_id]);
    $results = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Competition Results - UniFest 2026</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Your main CSS styles */
        .winner-card {
            border-left: 4px solid #FFD700;
            background: linear-gradient(135deg, #fffaf0, #fff);
        }
        .runner-up {
            border-left: 4px solid #C0C0C0;
        }
        .second-runner-up {
            border-left: 4px solid #CD7F32;
        }
    </style>
</head>
<body>
    <!-- Navigation from main.html -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-graduation-cap me-2"></i>UniFest 2026
            </a>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="text-center mb-4">Competition Results</h1>

        <!-- Competition Selection -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET">
                    <div class="row">
                        <div class="col-md-8">
                            <label class="form-label">Select Competition to View Results</label>
                            <select name="competition_id" class="form-select" onchange="this.form.submit()">
                                <option value="">-- Select Competition --</option>
                                <?php foreach ($competitions as $comp): ?>
                                <option value="<?php echo $comp['id']; ?>" <?php echo isset($_GET['competition_id']) && $_GET['competition_id'] == $comp['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($comp['name']); ?> (<?php echo date('M j', strtotime($comp['event_datetime'])); ?>)
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <?php if (isset($_GET['competition_id']) && !empty($results)): ?>
        <!-- Results Display -->
        <div class="row">
            <!-- Top 3 Winners -->
            <div class="col-md-4 mb-4">
                <div class="card winner-card">
                    <div class="card-body text-center">
                        <i class="fas fa-trophy fa-3x text-warning mb-3"></i>
                        <h4>1st Place</h4>
                        <h5 class="text-primary"><?php echo htmlspecialchars($results[0]['student_name']); ?></h5>
                        <p class="mb-1"><?php echo htmlspecialchars($results[0]['college_name']); ?></p>
                        <p class="mb-1">Marks: <strong><?php echo number_format($results[0]['average_marks'], 2); ?></strong></p>
                    </div>
                </div>
            </div>

            <?php if (isset($results[1])): ?>
            <div class="col-md-4 mb-4">
                <div class="card runner-up">
                    <div class="card-body text-center">
                        <i class="fas fa-medal fa-3x text-secondary mb-3"></i>
                        <h4>2nd Place</h4>
                        <h5 class="text-primary"><?php echo htmlspecialchars($results[1]['student_name']); ?></h5>
                        <p class="mb-1"><?php echo htmlspecialchars($results[1]['college_name']); ?></p>
                        <p class="mb-1">Marks: <strong><?php echo number_format($results[1]['average_marks'], 2); ?></strong></p>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if (isset($results[2])): ?>
            <div class="col-md-4 mb-4">
                <div class="card second-runner-up">
                    <div class="card-body text-center">
                        <i class="fas fa-award fa-3x text-danger mb-3"></i>
                        <h4>3rd Place</h4>
                        <h5 class="text-primary"><?php echo htmlspecialchars($results[2]['student_name']); ?></h5>
                        <p class="mb-1"><?php echo htmlspecialchars($results[2]['college_name']); ?></p>
                        <p class="mb-1">Marks: <strong><?php echo number_format($results[2]['average_marks'], 2); ?></strong></p>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Full Results Table -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Complete Results</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Student Name</th>
                                <th>College</th>
                                <th>Roll Number</th>
                                <th>Average Marks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results as $index => $result): ?>
                            <tr>
                                <td>
                                    <?php if ($index == 0): ?>
                                        <span class="badge bg-warning">1st</span>
                                    <?php elseif ($index == 1): ?>
                                        <span class="badge bg-secondary">2nd</span>
                                    <?php elseif ($index == 2): ?>
                                        <span class="badge bg-danger">3rd</span>
                                    <?php else: ?>
                                        <span class="badge bg-light text-dark"><?php echo $index + 1; ?>th</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($result['student_name']); ?></td>
                                <td><?php echo htmlspecialchars($result['college_name']); ?></td>
                                <td><?php echo htmlspecialchars($result['roll_number']); ?></td>
                                <td><strong><?php echo number_format($result['average_marks'], 2); ?></strong></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php elseif (isset($_GET['competition_id'])): ?>
            <div class="alert alert-info">No results available for this competition yet.</div>
        <?php endif; ?>
    </div>

    <!-- Footer from main.html -->
    <footer class="footer mt-5">
        <!-- Your footer content -->
    </footer>
</body>
</html>
