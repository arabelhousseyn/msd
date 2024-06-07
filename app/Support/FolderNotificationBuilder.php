<?php

namespace App\Support;

use App\Models\Company;
use App\Models\Document;
use App\Models\Folder;
use App\Models\User;
use App\Mail\FolderCreate;
use App\Notifications\FolderCreateNotification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use App\Mail\FolderAssign;
use App\Notifications\FolderAssignNotification;
use App\Mail\FolderStatus as FolderStatusMail;
use App\Enums\FolderStatus;
use App\Notifications\FolderStatusNotification;
use App\Mail\DocumentCreate;
use App\Notifications\DocumentCreateNotification;

class FolderNotificationBuilder
{
    private User $user;
    private Company $company;

    public function __construct(private readonly Folder $folder, private readonly string $type, private ?Document $document = null, private readonly mixed $file = null)
    {
        $this->resolveType();

        $this->user = User::with('company')->find($this->folder->user_id);
        $this->company = $this->user->company()->first();
        $this->configureSmtp($this->company->smtp);
    }

    private function resolveType(): void
    {
        match ($this->type) {
            'create', 'assign', 'document', 'status' => true,
            default => new \Exception()
        };
    }

    public function send(): void
    {
        switch ($this->type) {
            case 'create': $this->create(); break;
            case 'assign': $this->assign(); break;
            case 'status' : $this->status(); break;
            case 'document' : $this->document(); break;
        }
    }

    private function create(): void
    {
        Config::set('app.name', $this->company->name ?? env('APP_NAME'));

        $data = [
            'from_email' => $this->company->email ?? config('mail.from.address'),
            'from_name' => $this->company->name ?? config('mail.from.name'),
            'to_email' => $this->user->email,
            'to_name' => $this->user->full_name,
            'folder_name' => $this->folder->title,
        ];

        Mail::to($this->user->email)->send(new FolderCreate($data));

        $this->user->notify(new FolderCreateNotification($this->folder));
    }

    private function assign(): void
    {
        Config::set('app.name', $this->company->name ?? env('APP_NAME'));

        $data = [
            'from_email' => $this->company->email ?? config('mail.from.address'),
            'from_name' => $this->company->name ?? config('mail.from.name'),
            'to_email' => $this->user->email,
            'to_name' => $this->user->full_name,
            'folder_name' => $this->folder->title,
            'assigner_name' => auth()->user()->full_name,
            'assigner_position' => auth()->user()->position == null ? 'Super admin' : auth()->user()->position
        ];

        Mail::to($this->user->email)->send(new FolderAssign($data));

        $this->user->notify(new FolderAssignNotification($this->folder));
    }

    private function status(): void
    {
        Config::set('app.name', $this->company->name ?? env('APP_NAME'));

        $data = [
            'from_email' => $this->company->email ?? config('mail.from.address'),
            'from_name' => $this->company->name ?? config('mail.from.name'),
            'to_email' => $this->user->email,
            'to_name' => $this->user->full_name,
            'folder_name' => $this->folder->title,
            'status' => FolderStatus::getDescription($this->folder->status->value)
        ];

        Mail::to($this->user->email)->send(new FolderStatusMail($data));

        $this->user->notify(new FolderStatusNotification($this->folder));
    }

    private function document(): void
    {
        Config::set('app.name', $this->company->name ?? env('APP_NAME'));

        $data = [
            'from_email' => $this->company->email ?? config('mail.from.address'),
            'from_name' => $this->company->name ?? config('mail.from.name'),
            'to_email' => $this->user->email,
            'to_name' => $this->user->full_name,
            'folder_name' => $this->folder->title,
            'document_name' => $this->document->title,
            'document_url' => $this->document->url,
            'document_format' => $this->document->format,
        ];

        Mail::to($this->user->email)->send(new DocumentCreate($data, $this->file));

        $this->user->notify(new DocumentCreateNotification($this->document));
    }

    private function configureSmtp(array $smtp): void
    {
        Config::set('mail.mailers.smtp.encryption', $smtp['encryption']);
        Config::set('mail.mailers.smtp.host', $smtp['host']);
        Config::set('mail.mailers.smtp.port', $smtp['port']);
        Config::set('mail.mailers.smtp.username', $smtp['username']);
        Config::set('mail.mailers.smtp.password', $smtp['password']);
    }
}
