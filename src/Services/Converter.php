<?php

namespace App\Services;


class Converter
{

    public function Conv($file){
        $this->CheckFile($file);
    }

    private function CheckFile($file)
    {
        $path_parts = pathinfo($file);
        if ($path_parts['extension'] == 'csv') {
            $fileName = $path_parts['filename'];
            $filedirname = $path_parts['dirname'];
            $this->CsvToJson($file, $fileName,$filedirname);
        } elseif ($path_parts['extension'] == 'json') {    
            $fileName = $path_parts['filename'];
            $filedirname = $path_parts['dirname'];
            $this->JsonToCsv($file, $fileName,$filedirname);
        }
    }

    private function JsonToCsv($file, $fileName,$filedirname)
    {
        if (($json = file_get_contents($file)) == false) {
            return null;
        }
        
        $data = json_decode($json, true);
        $myfile = fopen("$filedirname/$fileName.csv", 'w');
        $header = false;
        foreach ($data as $row) {
            if (empty($header)) {
                $header = array_keys($row);
                fputcsv($myfile, $header);
                $header = array_flip($header);
            }
            fputcsv($myfile, array_merge($header, $row));
        }
        fclose($myfile);
        return $myfile;
    }

    

    private function CsvToJson($file, $fileName)
    {
        if (($handle = fopen($file, "r")) === false) {
            return null;
        }
        $delimiter = $this->detectDelimiter($file);
        if ($delimiter == ";" || $delimiter == ",") {
            $csv_headers = fgetcsv($handle, 4000, $delimiter);
            $csv_json = array();

            while ($row = fgetcsv($handle, 4000, $delimiter)) {
                $csv_json[] = array_combine($csv_headers, $row);
            }

            fclose($handle);

            $myfile = fopen("$fileName.json", "w");
            fwrite($myfile, json_encode($csv_json));
            fclose($myfile);
            return $myfile;
        } else {
            return null;
        }
    }

    public function detectDelimiter($csvFile)
    {
        $delimiters = [";" => 0, "," => 0, "\t" => 0, "|" => 0];

        $handle = fopen($csvFile, "r");
        $firstLine = fgets($handle);
        fclose($handle);
        foreach ($delimiters as $delimiter => &$count) {
            $count = count(str_getcsv($firstLine, $delimiter));
        }
        return array_search(max($delimiters), $delimiters);
    }
}