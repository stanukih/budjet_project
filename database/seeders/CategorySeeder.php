<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    use WithoutModelEvents;
    public function run(): void
    {
        /*Category::factory()->create([
            'title' => 'Asuminen'
        ]);

        Category::factory()->create([
            'title' => 'Ruoka ja päivittäistavarat'
        ]);

        Category::factory()->create([
            'title' => 'Liikkuminen'
        ]);

        Category::factory()->create([
            'title' => 'Terveys ja hyvinvointi'
        ]);

        Category::factory()->create([
            'title' => 'Viestintä ja media'
        ]);

        Category::factory()->create([
            'title' => 'Vaatteet ja varusteet'
        ]);

        Category::factory()->create([
            'title' => 'Vapaa-aika ja harrastukset'
        ]);

        Category::factory()->create([
            'title' => 'Ravintola ja kahvilat'
        ]);

        Category::factory()->create([
            'title' => 'Lahjat ja juhlat'
        ]);

        Category::factory()->create([
            'title' => 'Matkustaminen'
        ]);

        Category::factory()->create([
            'title' => 'Opiskelu ja koulutus'
        ]);

        Category::factory()->create([
            'title' => 'Muut kulut'
        ]);*/
        $data = ['Asuminen',
            'Ruoka ja päivittäistavarat',
            'Liikkuminen',
            'Terveys ja hyvinvointi',
            'Viestintä ja media',
            'Vaatteet ja varusteet',
            'Vapaa-aika ja harrastukset',
            'Ravintola ja kahvilat',
            'Lahjat ja juhlat',
            'Matkustaminen',
            'Opiskelu ja koulutus',
            'Muut kulut'];
        foreach ($data as $item) {
            $category = new Category();
            $category['title'] = $item;
            $category->save();
        }
    }
}
