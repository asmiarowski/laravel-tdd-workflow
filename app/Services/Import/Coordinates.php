<?php namespace App\Services\Import;

use App\Exceptions\Import\Coordinates\InvalidFieldsException;

class Coordinates
{
    /**
     * Extract coordinates in CSV file
     * @param string $filePath
     * @return array
     * @throws InvalidFieldsException
     */
    public function extractCSV(string $filePath): array
    {
        // We use clean PHP class for dealing with file in OOP way
        $file = new \SplFileObject($filePath);

        $result = [];
        // Put first line into field names array
        $fields = $this->extractCSVLine($file->fgets());
        // Check if proper fields are provided
        if (count($fields) != 2 || array_diff($fields, ['latitude', 'longitude']) !== []) {
            throw new InvalidFieldsException();
        }

        while (!$file->eof()) {
            $line = $this->extractCSVLine($file->fgets());
            // Map values from the line into keys extracted before loop.
            $result[] = array_combine($fields, $line);
        }

        return $result;
    }

    /**
     * Extract fields from a line in CSV file
     * @param string $line
     * @param string $separator
     * @return array
     */
    protected function extractCSVLine(string $line, string $separator = ','): array
    {
        $line = explode($separator, $line);
        // It is often a good idea to trim spaces when extracting data from text files
        $line = array_map('trim', $line);

        return $line;
    }
}