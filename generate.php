<?php
// generate.php

// 1. Source: The clean, verified Iran CIDR list (herrbischoff)
$sourceUrl = 'https://raw.githubusercontent.com/herrbischoff/country-ip-blocks/master/ipv4/ir.cidr';
$rawList = file_get_contents($sourceUrl);

if ($rawList === false) {
    die("Error: Could not fetch list.");
}

// 2. Split into array and remove empty lines
$lines = explode("\n", $rawList);
$jsonOutput = [];

foreach ($lines as $line) {
    $line = trim($line);
    // Validate it looks like a CIDR (basic check to ensure file integrity)
    if (!empty($line) && strpos($line, '/') !== false) {
        // Amnezia strict format: [{"hostname": "1.2.3.4/24"}, ...]
        $jsonOutput[] = ["hostname" => $line];
    }
}

// 3. Save as 'iran-routes.json'
// Using JSON_PRETTY_PRINT is optional but helps with debugging
file_put_contents('iran-routes.json', json_encode($jsonOutput));

echo "Success! Generated " . count($jsonOutput) . " rules.\n";
?>
