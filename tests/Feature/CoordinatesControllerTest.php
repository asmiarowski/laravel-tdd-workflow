<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CoordinatesControllerTest extends TestCase
{
    /**
     * Check if file with coordinates is being uploaded correctly into the database
     */
    public function testUploadFile()
    {
        // First we prepare our example file for upload.
        $fileName = 'coordinates.csv';
        $filePath = base_path('tests/data/' . $fileName);

        $file = new UploadedFile($filePath, $fileName, 'text/csv', filesize($filePath), null, true);

        // We create a fake user to assign the coordinates to.
        $user = factory(User::class)->create();

        // Now we imitate the request, that we could make manually by Postman for example.
        $response = $this->post('/api/coordinates/upload', ['file' => $file, 'user_id' => $user->id], ['Accepts' => 'application/json']);
        // We make sure everything went fine and there was no error thrown.
        $response->assertExactJson(['success' => true]);

        // Last thing, we check if database has our coordinates uploaded and assigned to proper user.
        $this->assertDatabaseHas('coordinates', ['user_id' => $user->id, 'latitude' => 52.2297, 'longitude' => 21.0122]);
        $this->assertDatabaseHas('coordinates', ['user_id' => $user->id, 'latitude' => 41.8781, 'longitude' => 87.6298]);
        $this->assertDatabaseHas('coordinates', ['user_id' => $user->id, 'latitude' => 51.5074, 'longitude' => 0.1278]);
    }
}
