<?php

use App\Models\StaticPage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class StaticPagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        StaticPage::firstOrCreate([
            'slug' => 'home',
        ], [
            'system'    => true,
            'name'      => 'Bienvenue sur 4sucres.org',
            'content'   => file_get_contents(database_path('seeds/home.md')),
        ]);

        StaticPage::firstOrCreate([
            'slug' => 'terms',
        ], [
            'name'      => 'Conditions générales d\'utilisation',
            'content'   => file_get_contents(database_path('seeds/terms.md')),
            'position'  => StaticPage::POSITION_FOOTER,
        ]);

        StaticPage::firstOrCreate([
            'slug' => 'charter',
        ], [
            'name'      => 'Charte d\'utilisation',
            'content'   => file_get_contents(database_path('seeds/charter.md')),
            'position'  => StaticPage::POSITION_FOOTER,
        ]);

        StaticPage::firstOrCreate([
            'slug' => 'vocabank',
        ], [
            'name'      => 'VocaBank',
            'content'   => 'https://vocabank.org',
            'type'      => StaticPage::TYPE_REDIRECT_BLANK,
            'position'  => StaticPage::POSITION_HEADER,
        ]);

        StaticPage::firstOrCreate([
            'slug' => 'github',
        ], [
            'name'      => 'GitHub',
            'content'   => 'https://github.com/4sucres/board',
            'type'      => StaticPage::TYPE_REDIRECT_BLANK,
            'position'  => StaticPage::POSITION_FOOTER,
        ]);

        StaticPage::firstOrCreate([
            'slug' => 'tipeee',
        ], [
            'name'      => 'Tipeee',
            'content'   => 'https://fr.tipeee.com/4sucres',
            'type'      => StaticPage::TYPE_REDIRECT_BLANK,
            'position'  => StaticPage::POSITION_FOOTER,
        ]);
    }
}
