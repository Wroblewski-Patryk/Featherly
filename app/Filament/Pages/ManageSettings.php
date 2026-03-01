<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use App\Models\Page as PageModel;
use App\Models\Setting;
use Filament\Notifications\Notification;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationGroup = 'Ustawienia';
    protected static ?string $title = 'Strona główna i Blog';

    protected static string $view = 'filament.pages.manage-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $homeSlug = Setting::where('key', 'home_page_slug')->value('value') ?? 'home';
        $blogSlug = Setting::where('key', 'blog_page_slug')->value('value') ?? 'blog';

        $this->form->fill([
            'home_page_slug' => $homeSlug,
            'blog_page_slug' => $blogSlug,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
            Select::make('home_page_slug')
            ->label('Strona główna (Wybierz z listy)')
            ->options(PageModel::pluck('title', 'slug'))
            ->required(),
            Select::make('blog_page_slug')
            ->label('Strona z artykułami (Wybierz z listy)')
            ->options(PageModel::pluck('title', 'slug'))
            ->required(),
        ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        Setting::updateOrCreate(['key' => 'home_page_slug'], ['value' => $data['home_page_slug']]);
        Setting::updateOrCreate(['key' => 'blog_page_slug'], ['value' => $data['blog_page_slug']]);

        Notification::make()
            ->title('Zapisano ustawienia')
            ->success()
            ->send();
    }
}
