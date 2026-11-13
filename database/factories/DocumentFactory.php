<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

if (! function_exists('get_mime_type')) {
    function get_mime_type($filename)
    {
        $idx = explode('.', $filename);
        $count_explode = count($idx);
        $idx = strtolower($idx[$count_explode - 1]);

        $mimet = [
            // images
            'png' => 'image/png',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',

            // adobe
            'pdf' => 'application/pdf',

            // ms office
            'doc' => 'application/msword',
            'docx' => 'application/msword',
        ];

        if (isset($mimet[$idx])) {
            return $mimet[$idx];
        } else {
            return 'application/octet-stream';
        }
    }
}

class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $extensions = ['.png', '.gif', '.jpg', '.pdf'];
        $fileName = $this->faker->word().$extensions[array_rand($extensions)];

        return [
            'name' => $fileName,
            'path' => 'storage/'.$fileName,
            'type' => get_mime_type($fileName),
            'size' => rand(100, 2000) * 10000,
            'user_id' => User::where('role', '=', '0')->get()->random()->id,
        ];
    }
}
