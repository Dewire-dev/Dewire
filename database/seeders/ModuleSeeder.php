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
                'slug' => 'chats',
                'name' => 'Chat',
                'description' => 'Envoi de messages en temps réel via un salon de discussion.',
                'color' => '#e91e63',
            ],
            [
                'slug' => 'mails',
                'name' => 'Email',
                'description' => 'Envoi et lecture de messages via E-mail interne et SMTP.',
                'color' => '#2196f3',
            ],
            [
                'slug' => 'files',
                'name' => 'File',
                'description' => 'Stockage et gestion de fichiers.',
                'color' => '#795548',
            ],
            [
                'slug' => 'kanbans',
                'name' => 'Kanban',
                'description' => 'Gestion de projet via un tableau kanban avec drag and drop.',
                'color' => '#ffc107',
            ],
            [
                'slug' => 'lists',
                'name' => 'List',
                'description' => 'Listes de choses à acheter.',
                'color' => '#9c27b0',
            ],
            [
                'slug' => 'notes',
                'name' => 'Note',
                'description' => 'Prise de note en temps réel via éditeur de texte.',
                'color' => '#4caf50',
            ],
            [
                'slug' => 'plannings',
                'name' => 'Planning',
                'description' => 'Calendrier pour afficher des évènements.',
                'color' => '#3f51b5',
            ],
            [
                'slug' => 'times',
                'name' => 'Time',
                'description' => 'Estimation du temps de travail passé sur différentes tâches par semaine.',
                'color' => '#f44336',
                'is_generic' => true,
            ],
        ];

        foreach ($modules as $module) {
            Module::updateOrCreate($module);
        }
    }
}
