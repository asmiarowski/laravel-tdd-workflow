<?php

namespace App\Http\Controllers;

use App\Exceptions\Import\Coordinates\InvalidFieldsException;
use App\Http\Requests\Coordinates\ImportCsvRequest;
use App\Services\Import\Coordinates;
use Illuminate\Support\Facades\DB;

class CoordinatesController extends Controller
{
    /**
     * Upload coordinates file for a user into the database
     * @param ImportCsvRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadFile(ImportCsvRequest $request)
    {
        $import = new Coordinates();

        // Try to export data from CSV file into PHP array
        try {
            $records = $import->extractCSV($request->file('file')->getPathname());
        } catch (InvalidFieldsException $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }

        foreach ($records as &$record) {
            $record['user_id'] = $request->input('user_id');
        }

        // Mass insert multiple records for performance.
        $success = DB::table('coordinates')->insert($records);

        return response()->json(compact('success'));
    }
}
