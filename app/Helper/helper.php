<?php

if (!function_exists('decompressGzFile')) {
    /**
     * Decompress GZ File
     *
     * @param  string  $filePath
     * @return string
     */
    function decompressGzFile($filePath)
    {
        $bufferSize = 4096; // read 4kb at a time
        $outFileName = str_replace('.gz', '', $filePath);

        $file = gzopen($filePath, 'rb');
        $outFile = fopen($outFileName, 'wb');

        while (!gzeof($file)) {
            fwrite($outFile, gzread($file, $bufferSize));
        }

        fclose($outFile);
        gzclose($file);

        $content = file_get_contents($outFileName);
        unlink($outFileName); // delete the decompressed file

        return $content;
    }
}

if (!function_exists('parseCsvToArray')) {
    /**
     * Convert csv to Array
     *
     * @param  string  $csvContent
     * @return string
     */
    function parseCsvToArray($csvContent)
    {
        $lines = explode("\n", $csvContent);
        $header = str_getcsv(array_shift($lines));
        $data = [];

        foreach ($lines as $line) {
            if (!empty(trim($line))) {
                $row = str_getcsv($line);
                if (count($row) > count($header)) {
                    // Trim extra columns
                    $row = array_slice($row, 0, count($header));
                } elseif (count($row) < count($header)) {
                    // Pad with null values
                    $row = array_pad($row, count($header), null);
                }

                if (count($row) == count($header)) {
                    $data[] = array_combine($header, $row);
                }
            }
        }

        return $data;
    }
}
