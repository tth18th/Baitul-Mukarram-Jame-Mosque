<?php

class PrayerTimetable {
    private $response;
    private $data;
    private $api_url = "https://api.aladhan.com/v1/calendarByCity/{year}/{month}?city=Dundee&country=GB&method=3&timezonestring=Europe/London&school=1";

    // Monthly Jamā‘ah offsets (fallback if dynamic adjustment is disabled)
    private $monthly_jamaah_offsets = [
        1  => ['Fajr' => 90, 'Dhuhr' => 25, 'Asr' => 30, 'Maghrib' => 10, 'Isha' => 10],  // January
        2  => ['Fajr' => 85, 'Dhuhr' => 28, 'Asr' => 32, 'Maghrib' => 10, 'Isha' => 10],  // February
        3  => ['Fajr' => 70, 'Dhuhr' => 30, 'Asr' => 35, 'Maghrib' => 10, 'Isha' => 10],  // March
        4  => ['Fajr' => 60, 'Dhuhr' => 33, 'Asr' => 37, 'Maghrib' => 10, 'Isha' => 10],  // April
        5  => ['Fajr' => 50, 'Dhuhr' => 36, 'Asr' => 39, 'Maghrib' => 10, 'Isha' => 10],  // May
        6  => ['Fajr' => 40, 'Dhuhr' => 40, 'Asr' => 42, 'Maghrib' => 10, 'Isha' => 10],  // June
        7  => ['Fajr' => 45, 'Dhuhr' => 40, 'Asr' => 42, 'Maghrib' => 10, 'Isha' => 10],  // July
        8  => ['Fajr' => 55, 'Dhuhr' => 38, 'Asr' => 40, 'Maghrib' => 10, 'Isha' => 10],  // August
        9  => ['Fajr' => 65, 'Dhuhr' => 35, 'Asr' => 38, 'Maghrib' => 10, 'Isha' => 10],  // September
        10 => ['Fajr' => 75, 'Dhuhr' => 30, 'Asr' => 34, 'Maghrib' => 10, 'Isha' => 10],  // October
        11 => ['Fajr' => 85, 'Dhuhr' => 27, 'Asr' => 31, 'Maghrib' => 10, 'Isha' => 10],  // November
        12 => ['Fajr' => 90, 'Dhuhr' => 25, 'Asr' => 30, 'Maghrib' => 10, 'Isha' => 10],  // December
    ];

    // 🔧 CONFIG: Enable/disable dynamic daylight-based adjustment
    private $enable_dynamic_adjustment = true;

 private $selected_year;
private $selected_month;

public function __construct($year = null, $month = null) {
    $this->selected_year = $year ?? date('Y');
    $this->selected_month = $month ?? date('n');
    $url = $this->buildApiUrl();
    $this->response = $this->checkIntegrityOfData($url);
    $this->data = json_decode($this->response);
}

private function buildApiUrl() {
    return str_replace(
        ["{year}", "{month}"],
        [$this->selected_year, $this->selected_month],
        $this->api_url
    );
}

    public function checkIntegrityOfData($url) {
        $txt = @file_get_contents($url);
        if ($txt === FALSE) {
            die("<div class='alert alert-danger'>Error: Could not fetch prayer times. Please try again later.</div>");
        }
        return $txt;
    }

    public function checkdateandchange() {
        $year = date('Y');
        $month = date('n');
        return str_replace(["{year}", "{month}"], [$year, $month], $this->api_url);
    }

    public function datecomp($api_date): bool {
        $today = date("d-m-Y");
        return $today !== $api_date;
    }

    private function addMinutesToTime($time, $minutes) {
        $time = str_replace([' (UTC)', ' (BST)', ' (GMT)'], '', $time);
        $timestamp = strtotime($time);
        if ($timestamp === false) return $time;
        return date('H:i', strtotime("+$minutes minutes", $timestamp));
    }

    private function getCurrentMonthOffsets() {
        $month = (int)date('n');
        return $this->monthly_jamaah_offsets[$month] ?? $this->monthly_jamaah_offsets[1];
    }

    /**
     * 🔥 ADVANCED: Dynamically adjust offset based on day length (sunrise to sunset)
     */
    private function calculateDynamicOffset($sunrise, $sunset, $prayer) {
        if (!$this->enable_dynamic_adjustment) {
            $monthly = $this->getCurrentMonthOffsets();
            return $monthly[$prayer] ?? 10;
        }

        $rise = strtotime($sunrise);
        $set = strtotime($sunset);

        if ($rise === false || $set === false) {
            $monthly = $this->getCurrentMonthOffsets();
            return $monthly[$prayer] ?? 10;
        }

        $day_length_minutes = ($set - $rise) / 60;
        $min_day = 360;
        $max_day = 1080;
        $ratio = max(0.0, min(1.0, ($day_length_minutes - $min_day) / ($max_day - $min_day)));

        $offset_ranges = [
            'Dhuhr' => [20, 45],
            'Asr'   => [25, 50],
            'Fajr'  => [70, 40],
            'Isha'  => [10, 15],
        ];

        if (isset($offset_ranges[$prayer])) {
            [$min_offset, $max_offset] = $offset_ranges[$prayer];
            if ($prayer === 'Fajr') $ratio = 1 - $ratio;
            return (int)round($min_offset + ($ratio * ($max_offset - $min_offset)));
        }

        $monthly = $this->getCurrentMonthOffsets();
        return $monthly[$prayer] ?? 10;
    }

    // ✅ FIXED: Summer = April (4) to September (9)
    private function getJumuahTime($month) {
        return ($month >= 4 && $month <= 9) ? "13:30" : "13:15";
    }

    public function generateTimetableMonth() {
        if (!isset($this->data->data) || empty($this->data->data)) {
            echo "<div class='alert alert-warning'>No prayer time data available for this month.</div>";
            return;
        }

        echo "<div class='swipe-container my-4'>";
        echo "<h3 class='mb-3'>Monthly Prayer Timetable — Dundee</h3>";
        echo "<table class='table table-bordered table-striped align-middle'>";
        echo "<thead class='table-dark'><tr>";
        echo "<th>Gregorian Date</th>";
        echo "<th>Hijri Date</th>";
        echo "<th>Weekday</th>";

        $prayer_order = [
            'Sunrise',
            'Fajr',
            'Dhuhr',
            'Jumuah',
            'Asr',
            'Sunset',
            'Maghrib',
            'Isha'
        ];

        foreach ($prayer_order as $prayer) {
            if (in_array($prayer, ['Sunrise', 'Sunset'])) {
                echo "<th>$prayer</th>"; // Only one column
            } elseif ($prayer === 'Jumuah') {
                echo "<th>Jumu’ah<br><small>Start</small></th>"; // Only one column
            } else {
                echo "<th>$prayer<br><small>Adhan</small></th>";
                echo "<th><small>Jamā‘ah</small></th>";
            }
        }

        echo "</tr></thead><tbody>";

        foreach ($this->data->data as $day) {
            $gregorian = $day->date->gregorian;
            $hijri = $day->date->hijri;
            $date_greg = $gregorian->date;
            $date_hijri = $hijri->date;
            $weekday = $gregorian->weekday->en;

            $row_class = $this->datecomp($date_greg) ? '' : 'table-primary fw-bold';

            $sunrise_time = str_replace([' (UTC)', ' (BST)', ' (GMT)'], '', $day->timings->Sunrise ?? '06:00');
            $sunset_time = str_replace([' (UTC)', ' (BST)', ' (GMT)'], '', $day->timings->Sunset ?? '18:00');

            echo "<tr class='$row_class'>";
            echo "<td>$date_greg</td>";
            echo "<td>$date_hijri</td>";
            echo "<td>$weekday</td>";

            foreach ($prayer_order as $prayer) {
                if ($prayer === 'Jumuah') {
                    $is_friday = ($weekday === 'Friday');
                    if ($is_friday) {
                        $jumuah_time = $this->getJumuahTime((int)$gregorian->month->number);
                        echo "<td class='table-success fw-bold'>$jumuah_time <span class='badge bg-success ms-1'><i class='fas fa-mosque'></i></span></td>";
                    } else {
                        // ✅ FIXED: No colspan='2' — only one column now
                        echo "<td class='text-muted fst-italic text-center'>—</td>";
                    }
                } elseif (in_array($prayer, ['Sunrise', 'Sunset'])) {
                    $adhan_time = str_replace([' (UTC)', ' (BST)', ' (GMT)'], '', $day->timings->{$prayer} ?? 'N/A');
                    echo "<td>$adhan_time</td>";
                } else {
                    $adhan_raw = $day->timings->{$prayer} ?? 'N/A';
                    $adhan_time = str_replace([' (UTC)', ' (BST)', ' (GMT)'], '', $adhan_raw);
                    if ($prayer === 'Dhuhr') {
                    // ✅ FIXED Dhuhr Jamā‘ah time based on month
                    $jamaah_time = ($this->selected_month >= 4 && $this->selected_month <= 9) ? "13:30" : "13:15";
                } else {
                    $offset = $this->calculateDynamicOffset($sunrise_time, $sunset_time, $prayer);
                    $jamaah_time = $this->addMinutesToTime($adhan_raw, $offset);
                }
                    echo "<td>$adhan_time</td>";
                    echo "<td>$jamaah_time</td>";
                }
            }

            echo "</tr>";
        }

        echo "</tbody></table></div>";

        if ($this->enable_dynamic_adjustment) {
            echo "<div class='alert alert-info'>💡 Jamā‘ah times dynamically adjusted based on daylight duration.</div>";
        } else {
            echo "<div class='alert alert-secondary'>📅 Using fixed monthly Jamā‘ah offsets.</div>";
        }
    }

    public function dynamicTimetable() {
        if (!isset($this->data->data)) {
            echo "<div class='alert alert-warning'>No data available.</div>";
            return;
        }

        $today_data = null;
        foreach ($this->data->data as $day) {
            $gregorian = $day->date->gregorian;
            $date_greg = $gregorian->date;
            if (!$this->datecomp($date_greg)) {
                $today_data = $day;
                break;
            }
        }

        if (!$today_data) {
            echo "<div class='alert alert-warning'>Today's prayer times not found.</div>";
            return;
        }

        $gregorian = $today_data->date->gregorian;
        $hijri = $today_data->date->hijri;
        $weekday = $gregorian->weekday->en;
        $sunrise = str_replace([' (UTC)', ' (BST)', ' (GMT)'], '', $today_data->timings->Sunrise ?? '06:00');
        $sunset = str_replace([' (UTC)', ' (BST)', ' (GMT)'], '', $today_data->timings->Sunset ?? '18:00');

        echo '
        <div class="timetable-overlap my-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="timetable-box bg-light p-4 shadow text-center rounded">
                            <h4 class="mb-3">🕌 Today\'s Prayer Timetable — Dundee</h4>
                            <p class="mb-1"><strong>Gregorian:</strong> ' . $gregorian->date . ' (' . $weekday . ')</p>
                            <p class="mb-3"><strong>Hijri:</strong> ' . $hijri->date . ' ' . $hijri->month->en . '</p>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Prayer</th>
                                            <th>Adhan</th>
                                            <th>Jamā‘ah</th>
                                        </tr>
                                    </thead>
                                    <tbody>';

        $prayer_order = ['Fajr', 'Sunrise', 'Dhuhr', 'Jumuah', 'Asr', 'Sunset', 'Maghrib', 'Isha'];

        foreach ($prayer_order as $prayer) {
            if ($prayer === 'Jumuah') {
                // ✅ FIXED: Case-insensitive Friday detection
                $is_friday = strtolower($weekday) === 'friday';
                $jumuah_time = $this->getJumuahTime((int)$gregorian->month->number);

                $row_class = $is_friday ? 'table-success fw-bold' : 'text-muted';
                $display_time = $is_friday ? $jumuah_time : '—';

                echo "<tr class='$row_class'>";
                echo "<td><strong>Jumu’ah</strong> ";
                if ($is_friday) {
                    echo "<span class='badge bg-success'><i class='fas fa-mosque'></i> Friday</span>";
                }
                echo "</td>";

                if ($is_friday) {
                    // ✅ Output same time in both columns to maintain 3-column layout
                    echo "<td>$jumuah_time</td>";
                    echo "<td>$jumuah_time</td>";
                } else {
                    echo "<td colspan='2' class='text-center'>$display_time</td>";
                }
                echo "</tr>";
            } else {
                $adhan_raw = $today_data->timings->{$prayer} ?? 'N/A';
                $adhan_time = str_replace([' (UTC)', ' (BST)', ' (GMT)'], '', $adhan_raw);

                $row_class = in_array($prayer, ['Sunrise', 'Sunset']) ? 'text-muted' : 'fw-bold';

                 // ✅ Override Dhuhr Jamā‘ah time
                if ($prayer === 'Dhuhr') {
                    $current_month = (int)date('n');
                    $jamaah_time = ($current_month >= 4 && $current_month <= 9) ? "13:30" : "13:15";
                } else {
                    $offset = $this->calculateDynamicOffset($sunrise, $sunset, $prayer);
                    $jamaah_time = $this->addMinutesToTime($adhan_raw, $offset);
                }


                echo "<tr class='$row_class'>";
                echo "<td><strong>$prayer</strong></td>";

                if (in_array($prayer, ['Sunrise', 'Sunset'])) {
                    echo "<td colspan='2' class='text-center'>$adhan_time</td>";
                } else {
                    $offset = $this->calculateDynamicOffset($sunrise, $sunset, $prayer);
                    $jamaah_time = $this->addMinutesToTime($adhan_raw, $offset);
                    echo "<td>$adhan_time</td>";
                    echo "<td>$jamaah_time</td>";
                }

                echo "</tr>";
            }
        }

        echo '
                                </tbody>
                            </table>
                            <small class="text-muted d-block mt-2">
                                Times calculated for Dundee, Scotland. 
                                ' . ($this->enable_dynamic_adjustment ? 'Jamā‘ah times auto-adjusted by daylight duration.' : 'Using monthly preset offsets.') . '
                                <br>Jumu’ah: 1:30 PM (Oct-Mar), 1:45 PM (Apr-Sep).
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    }
}