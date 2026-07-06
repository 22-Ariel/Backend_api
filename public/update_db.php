<?php
$mysqli = new mysqli("127.0.0.1", "root", "", "api_alumni_karir", 3306);

// Add template setting
$result = $mysqli->query("SELECT * FROM web_settings WHERE `key` = 'template_surat_ijazah'");
if ($result->num_rows == 0) {
    $mysqli->query("INSERT INTO web_settings (`key`, `value`) VALUES ('template_surat_ijazah', '')");
}

echo "Database updated successfully.\n";
