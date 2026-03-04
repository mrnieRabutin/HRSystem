<?php
declare(strict_types=1);

function generatePdfFromTemplate(
    string $templatePath,
    string $pythonScriptPath,
    array $fields,
    string $outputName
): array {

    $outputDir = __DIR__ . '/../temp';
    if (!is_dir($outputDir)) {
        mkdir($outputDir, 0777, true);
    }

    $outputPdf = $outputDir . '/' . $outputName . '.pdf';
    $jsonFile = $outputDir . '/' . $outputName . '.json';

    // Save JSON file
    file_put_contents($jsonFile, json_encode($fields, JSON_UNESCAPED_UNICODE));

    // 🔥 IMPORTANT: FULL PYTHON PATH (CHANGE IF NEEDED)
    $pythonPath = 'C:\Users\HP\AppData\Local\Microsoft\WindowsApps\python.exe';

    // Escape paths properly for Windows
    $cmd = '"' . $pythonPath . '" "' .
           $pythonScriptPath . '" "' .
           $templatePath . '" "' .
           $outputPdf . '" "' .
           $jsonFile . '" 2>&1';

    $output = shell_exec($cmd);

    if (!file_exists($outputPdf)) {
        return [
            'ok' => false,
            'error' => $output ?: 'PDF file was not created.'
        ];
    }

    unlink($jsonFile);

    return [
        'ok' => true,
        'pdf_path' => $outputPdf
    ];
}