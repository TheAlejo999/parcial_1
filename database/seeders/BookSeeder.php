<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

use function Symfony\Component\String\s;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvPath = database_path('data/libros.csv');

        if (file_exists($csvPath)) {
            $file = fopen($csvPath, 'r');
            $header = fgetcsv($file);

            while (($row = fgetcsv($file)) !== false) {
                $data = array_combine($header, $row);

                Book::create([
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'ISBN' => $data['ISBN'],
                    'total_copies' => (int)$data['total_copies'],
                    'available_copies' => (int)$data['available_copies'],
                    'is_available' => strtolower($data['is_available']) === 'disponible',
                ]);
            }

            fclose($file);
        } else {
            echo "El archivo CSV no se encontró en la ruta: " . $csvPath;
        }
    }
}
