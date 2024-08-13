<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use App\Models\SupportRequest;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

class Support extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.support';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->minLength(3)
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                TextInput::make('subject')
                    ->required()
                    ->maxLength(255),
                Textarea::make('details')
                    ->required()
                    ->maxLength(5000),
            ])
            ->statePath('data');
    }

    public function submit()
    {
        $data = $this->form->getState();

        SupportRequest::create($data);

        $this->form->fill();
        
        // Send a notification to the user for successful submission
        Notification::make()
            ->title('Support Request Sent')
            ->body('Your support request has been successfully submitted.')
            ->actions([
                Action::make('ok')
                    ->label('OK')
                    ->color('success')
                    ->close(),
            ])
            ->persistent()
            ->success()
            ->send();
    }
}