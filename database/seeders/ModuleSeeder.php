<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            [
                'name' => 'Chat',
                'description' => 'Envoi de messages en temps réel via un salon de discussion.',
            ],
            [
                'name' => 'Email',
                'description' => 'Envoi et lecture de messages via E-mail interne et SMTP.',
            ],
            [
                'name' => 'File',
                'description' => 'Stockage et gestion de fichiers.',
            ],
            [
                'name' => 'Kanban',
                'description' => 'Gestion de projet via un tableau kanban avec drag and drop.',
            ],
            [
                'name' => 'List',
                'description' => 'Listes de choses à acheter.',
            ],
            [
                'name' => 'Note',
                'description' => 'Prise de note en temps réel via éditeur de texte.',
            ],
            [
                'name' => 'Planning',
                'description' => 'Calendrier pour afficher des évènements.',
            ],
            [
                'name' => 'Time',
                'description' => 'Estimation de temps de travail avec compteur.',
            ],
        ];

        foreach ($modules as $module) {
            Module::updateOrCreate($module);
        }
    }
}
