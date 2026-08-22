<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VilleSeeder extends Seeder
{
    public function run(): void
    {
        $villes = [
            'Casablanca', 'Rabat', 'Fès', 'Marrakech', 'Tanger', 'Agadir', 'Meknès', 'Oujda', 'Kenitra', 'Tétouan',
            'Safi', 'Temara', 'Inzegane', 'Mohammedia', 'Laâyoune', 'Khouribga', 'Béni Mellal', 'El Jadida', 'Taza', 'Nador',
            'Settat', 'Larache', 'Ksar El Kebir', 'Khemisset', 'Guelmim', 'Berrechid', 'Wad Zem', 'Fquih Ben Salah', 'Taourirt', 'Berkane',
            'Sidi Slimane', 'Sidi Kacem', 'Khenifra', 'Ifrane', 'Taroudant', 'Essaouira', 'Tiznit', 'Ouarzazate', 'Errachidia', 'Tan-Tan',
            'Dakhla', 'Chefchaouen', 'Al Hoceïma', 'Azrou', 'Midelt', 'Zagora', 'Tinghir', 'Asilah', 'Sefrou', 'Fnideq',
            'M\'diq', 'Martil', 'Skhirat', 'Bouznika', 'Ben Guerir', 'Youssoufia', 'Ouezzane', 'Guercif', 'Aït Melloul', 'Biougra',
            'Tifelt', 'Souk El Arbaa', 'Sidi Bennour', 'Moulay Bousselham', 'Zaio', 'Imzouren', 'Jerada', 'Figuig', 'Tata', 'Assa',
            'Smara', 'Boujdour', 'Tarfaya', 'El Hajeb', 'Aznag', 'Chichaoua', 'Kelaat M\'Gouna', 'El Kelaa des Sraghna', 'Tahannaout', 'Amizmiz'
        ];

        $data = array_map(function ($nom) {
            return [
                'nom' => $nom,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $villes);

        DB::table('villes')->insert($data);
    }
}