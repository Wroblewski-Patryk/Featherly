<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Translation;

class AdminUiTranslationSeeder extends Seeder
{
    public function run(): void
    {
        $translations = [
            // Menu Groups
            'menu.content' => ['pl' => 'Treści', 'en' => 'Content'],
            'menu.pages' => ['pl' => 'Strony', 'en' => 'Pages'],
            'menu.posts' => ['pl' => 'Wpisy', 'en' => 'Posts'],
            'menu.categories' => ['pl' => 'Kategorie', 'en' => 'Categories'],
            'menu.projects' => ['pl' => 'Projekty', 'en' => 'Projects'],
            'menu.clients' => ['pl' => 'Klienci', 'en' => 'Clients'],
            'menu.forms' => ['pl' => 'Formularze', 'en' => 'Forms'],
            'menu.library' => ['pl' => 'Biblioteka', 'en' => 'Library'],
            'menu.media' => ['pl' => 'Media', 'en' => 'Media'],
            'menu.templates' => ['pl' => 'Szablony', 'en' => 'Templates'],
            'menu.design' => ['pl' => 'Wygląd', 'en' => 'Design'],
            'menu.theme' => ['pl' => 'Motyw', 'en' => 'Theme'],
            'menu.colors' => ['pl' => 'Kolory', 'en' => 'Colors'],
            'menu.fonts' => ['pl' => 'Fonty', 'en' => 'Fonts'],
            'menu.typography' => ['pl' => 'Typografia', 'en' => 'Typography'],
            'menu.metrics' => ['pl' => 'Wymiary', 'en' => 'Sizes / Metrics'],
            'menu.effects' => ['pl' => 'Cienie / Efekty', 'en' => 'Shadows / Effects'],
            'menu.blocks' => ['pl' => 'Bloki', 'en' => 'Blocks'],
            'menu.system' => ['pl' => 'System', 'en' => 'System Settings'],
            'menu.translations' => ['pl' => 'Tłumaczenia', 'en' => 'Translations'],
            'menu.languages' => ['pl' => 'Języki', 'en' => 'Languages'],
            'menu.users' => ['pl' => 'Użytkownicy', 'en' => 'Users'],
            'menu.settings' => ['pl' => 'Ustawienia', 'en' => 'Settings'],
            
            // Navigation Elements
            'nav.language' => ['pl' => 'Język', 'en' => 'Language'],
            'nav.my_profile' => ['pl' => 'Mój Profil', 'en' => 'My Profile'],
            'nav.account_settings' => ['pl' => 'Ustawienia konta', 'en' => 'Account Settings'],
            'nav.support' => ['pl' => 'Pomoc', 'en' => 'Support'],
            'nav.logout' => ['pl' => 'Wyloguj się', 'en' => 'Logout'],
            
            // Theme Picker
            'theme.select_theme' => ['pl' => 'Wybierz motyw', 'en' => 'Choose Theme'],
            
            // SEO
            'seo.admin_panel' => ['pl' => 'Panel Administracyjny', 'en' => 'Admin Panel'],

            // Dashboard
            'dashboard.title' => ['pl' => 'Pulpit', 'en' => 'Dashboard'],
            'dashboard.welcome_alert' => ['pl' => 'Witaj w panelu administracyjnym Featherly. Uwierzytelnienie przebiegło pomyślnie.', 'en' => 'Welcome to Featherly Administrator Panel. You have successfully authenticated.'],
            'dashboard.pages' => ['pl' => 'Strony', 'en' => 'Pages'],
            'dashboard.pages_desc' => ['pl' => 'Zarządzaj stronami swojej witryny i korzystaj z wizualnego edytora bloków.', 'en' => 'Manage your website pages and utilize the Visual Block Builder.'],
            'dashboard.manage_pages' => ['pl' => 'Zarządzaj Stronami', 'en' => 'Manage Pages'],
            'dashboard.posts' => ['pl' => 'Wpisy na Blogu', 'en' => 'Blog Posts'],
            'dashboard.posts_desc' => ['pl' => 'Twórz i publikuj artykuły na blogu z pełnymi ustawieniami SEO.', 'en' => 'Write and publish blog articles with full SEO settings.'],
            'dashboard.manage_posts' => ['pl' => 'Zarządzaj Wpisami', 'en' => 'Manage Posts'],
        ];

        foreach ($translations as $key => $values) {
            Translation::updateOrCreate(
                ['group' => 'admin', 'key' => $key],
                ['text' => $values]
            );
        }
    }
}
