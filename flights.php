<?php include 'includes/header.php'; ?>

<main class="container">
    <div class="world-clock-box">
        <div class="clock-header">
            <span class="pulse"></span>
            <h4>Live World Clock</h4>
        </div>
        <div class="tz-flex">
            <?php 
            $places = ["New York" => "America/New_York", "Tokyo" => "Asia/Tokyo", "London" => "Europe/London"];
            foreach ($places as $name => $timezone): 
                $t = new DateTime("now", new DateTimeZone($timezone));
            ?>
                <div class="tz-card">
                    <span class="city-name"><?= $name ?></span>
                    <span class="city-time"><?= $t->format('H:i') ?></span>
                    <span class="city-date"><?= $t->format('D, M j') ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php
    $FltData = [
        ["flightNo" => "PR 1811", "airline" => "Philippine Airlines", "from" => "MNL", "to" => "DVO", "originTZ" => "Asia/Manila", "destTZ" => "Asia/Manila", "dep" => "2026-02-15 08:00", "duration" => 105, "type" => "domestic", "image" => "img/davao.jpg"],
        ["flightNo" => "5J 671", "airline" => "Cebu Pacific", "from" => "MNL", "to" => "CEB", "originTZ" => "Asia/Manila", "destTZ" => "Asia/Manila", "dep" => "2026-02-15 10:30", "duration" => 85, "type" => "domestic", "image" => "img/cebu.jpg"],
        ["flightNo" => "Z2 772", "airline" => "AirAsia PH", "from" => "MNL", "to" => "TAG", "originTZ" => "Asia/Manila", "destTZ" => "Asia/Manila", "dep" => "2026-02-15 13:45", "duration" => 95, "type" => "domestic", "image" => "img/bohol.jpg"],
        ["flightNo" => "DG 6111", "airline" => "Cebgo", "from" => "MNL", "to" => "USU", "originTZ" => "Asia/Manila", "destTZ" => "Asia/Manila", "dep" => "2026-02-15 15:20", "duration" => 65, "type" => "domestic", "image" => "img/coron.jpg"],
        ["flightNo" => "PR 2985", "airline" => "Philippine Airlines", "from" => "MNL", "to" => "TAC", "originTZ" => "Asia/Manila", "destTZ" => "Asia/Manila", "dep" => "2026-02-15 18:00", "duration" => 80, "type" => "domestic", "image" => "img/tacloban.jpg"],

        ["flightNo" => "SQ 917", "airline" => "Singapore Airlines", "from" => "MNL", "to" => "SIN", "originTZ" => "Asia/Manila", "destTZ" => "Asia/Singapore", "dep" => "2026-02-16 14:00", "duration" => 230, "type" => "international", "image" => "img/singapore.jpg"],
        ["flightNo" => "JL 742", "airline" => "Japan Airlines", "from" => "MNL", "to" => "NRT", "originTZ" => "Asia/Manila", "destTZ" => "Asia/Tokyo", "dep" => "2026-02-16 09:15", "duration" => 255, "type" => "international", "image" => "img/tokyo.jpg"],
        ["flightNo" => "CX 906", "airline" => "Cathay Pacific", "from" => "MNL", "to" => "HKG", "originTZ" => "Asia/Manila", "destTZ" => "Asia/Hong_Kong", "dep" => "2026-02-16 11:00", "duration" => 135, "type" => "international", "image" => "img/hongkong.jpg"],
        ["flightNo" => "KE 622", "airline" => "Korean Air", "from" => "MNL", "to" => "ICN", "originTZ" => "Asia/Manila", "destTZ" => "Asia/Seoul", "dep" => "2026-02-16 12:30", "duration" => 240, "type" => "international", "image" => "img/seoul.jpg"],
        ["flightNo" => "EK 333", "airline" => "Emirates", "from" => "MNL", "to" => "DXB", "originTZ" => "Asia/Manila", "destTZ" => "Asia/Dubai", "dep" => "2026-02-16 18:55", "duration" => 555, "type" => "international", "image" => "img/dubai.jpg"]
    ];

    $sections = ['domestic' => 'PH Flights', 'international' => 'Overseas'];

    foreach ($sections as $k => $val): ?>
        <h2 class="section-title"><?php echo $val; ?></h2>
        <div class="flight-grid">
            <?php 
            foreach ($FltData as $row): 
                if ($row['type'] == $k):
                    $orig_tz = $row['originTZ'];
                    $depart_obj = new DateTime($row['dep'], new DateTimeZone($orig_tz));
                    
                    $arrive_obj = clone $depart_obj;
                    $min_to_add = $row['duration'];
                    $arrive_obj->modify("+$min_to_add minutes");
                    
                    $dest_tz = $row['destTZ'];
                    $arrive_obj->setTimezone(new DateTimeZone($dest_tz));

                    $interval = $depart_obj->diff($arrive_obj);
                    $hrs = $interval->h;
                    $mins = $interval->i;
            ?>
                <div class="card">
                    <div class="card-img" style="background-image: url('<?= $row['image']; ?>')">
                        <?php if($row['duration'] > 300): ?>
                           <span class="status-badge" style="background: #e67e22;">LATE</span>
                        <?php else: ?>
                           <span class="status-badge">ON TIME</span>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <div class="card-header">
                            <span class="airline"><?php echo $row['airline']; ?></span>
                            <small><?php echo $row['flightNo']; ?></small>
                        </div>
                        <h3><?= $row['from']; ?> ✈ <?= $row['to']; ?></h3>
                        
                        <div class="time-info">
                            <div class="time-row">
                                <span class="label">DEPARTURE</span>
                                <span class="value"><?= $depart_obj->format('M j, Y | g:i A'); ?></span>
                            </div>
                            <div class="time-row">
                                <span class="label">ARRIVAL</span>
                                <span class="value"><?= $arrive_obj->format('M j, Y | g:i A'); ?></span>
                                <span class="tz-label"><?= $dest_tz; ?></span>
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            Duration: <?php echo $hrs . "h " . $mins . "m"; ?>
                        </div>
                    </div>
                </div>
            <?php 
                endif; 
            endforeach; 
            ?>
        </div>
    <?php endforeach; ?>
</main>

<?php include 'includes/footer.php'; ?>