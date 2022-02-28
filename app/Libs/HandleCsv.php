<?php

namespace App\Libs;

class HandleCsv
{
    public static function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        $handle = fopen($filename, 'r');
        if ($handle !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if (!$header)
                {
                    $row[0] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $row[0]);
                    $header = $row;
                } else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }

}