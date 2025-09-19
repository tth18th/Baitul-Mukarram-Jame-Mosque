<?php include 'includes/header.php'; ?>


<div class="container my-5">
    <h1 class="mb-4">🕌 Monthly Prayer Timetables</h1>
    <p class="lead">Select a month and year to view prayer times for Dundee, Scotland.</p>

    <?php
    // Get user-selected month/year or default to current
    $selected_month = isset($_GET['month']) ? (int)$_GET['month'] : (int)date('n');
    $selected_year = isset($_GET['year']) ? (int)$_GET['year'] : (int)date('Y');

    // Validate
    $selected_month = max(1, min(12, $selected_month));
    $selected_year = max(2020, min(2030, $selected_year)); // Adjust range as needed

    // Include class
    include_once("./js/script.php"); // Assuming this is where your class is
    ?>

    <!-- Month/Year Selector Form -->
    <form method="GET" class="mb-5 p-4 bg-light rounded shadow-sm">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="monthSelect" class="form-label">Select Month</label>
                <select name="month" id="monthSelect" class="form-select">
                    <?php
                    $months = [
                        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                    ];
                    foreach ($months as $num => $name):
                    ?>
                        <option value="<?= $num ?>" <?= $num === $selected_month ? 'selected' : '' ?>>
                            <?= $name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="yearSelect" class="form-label">Select Year</label>
                <select name="year" id="yearSelect" class="form-select">
                    <?php
                    $start_year = date('Y') - 2;
                    $end_year = date('Y') + 3;
                    for ($y = $end_year; $y >= $start_year; $y--):
                    ?>
                        <option value="<?= $y ?>" <?= $y === $selected_year ? 'selected' : '' ?>>
                            <?= $y ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fa-solid fa-calendar-check"></i> Load Timetable
                </button>
            </div>
        </div>
    </form>

    <!-- Display Selected Month Info -->
    <div class="alert alert-info mb-4">
        <strong>Showing timetable for:</strong>
        <?= $months[$selected_month] ?> <?= $selected_year ?>
    </div>

    <!-- Generate and Display Timetable -->
    <?php
    try {
        $timetable = new PrayerTimetable($selected_year, $selected_month);
        $timetable->generateTimetableMonth();
    } catch (Exception $e) {
        echo "<div class='alert alert-danger'>Error loading timetable: " . $e->getMessage() . "</div>";
    }
    ?>

</div>
<?php if ($selected_month != date('n') || $selected_year != date('Y')): ?>
    <div class="text-center mb-4">
        <a href="?month=<?= date('n') ?>&year=<?= date('Y') ?>" class="btn btn-outline-secondary">
            🗓️ Go to Current Month
        </a>
    </div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>