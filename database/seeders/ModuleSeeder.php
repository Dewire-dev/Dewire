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
                'color' => '#e91e63',
            ],
            [
                'name' => 'Email',
                'description' => 'Envoi et lecture de messages via E-mail interne et SMTP.',
                'color' => '#2196f3',
            ],
            [
                'name' => 'File',
                'description' => 'Stockage et gestion de fichiers.',
                'color' => '#795548',
            ],
            [
                'name' => 'Kanban',
                'description' => 'Gestion de projet via un tableau kanban avec drag and drop.',
                'color' => '#ffc107',
            ],
            [
                'name' => 'List',
                'description' => 'Listes de choses à acheter.',
                'color' => '#9c27b0',
            ],
            [
                'name' => 'Note',
                'description' => 'Prise de note en temps réel via éditeur de texte.',
                'color' => '#4caf50',
            ],
            [
                'name' => 'Planning',
                'description' => 'Calendrier pour afficher des évènements.',
                'color' => '#3f51b5',
            ],
            [
                'name' => 'Time',
                'description' => 'Estimation de temps de travail avec compteur.',
                'color' => '#f44336',
            ],
        ];

        foreach ($modules as $module) {
            Module::updateOrCreate($module);
        }
    }
}
