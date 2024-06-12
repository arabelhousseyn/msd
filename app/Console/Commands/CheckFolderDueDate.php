<?php

namespace App\Console\Commands;

use App\Mail\FolderDueDate;
use App\Models\User;
use App\Notifications\FolderDueDate as FolderDueDateNotification;
use App\Models\Folder;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckFolderDueDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-folder-due-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check folder due date';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            $current = Carbon::now()->format('Y-m-d');

            $folders = Folder::all();

            foreach ($folders as $folder) {
                $folder->load('user');
                $days = (new \Illuminate\Support\Carbon)->diffInDays($folder->end_at, $current);
                if($days <= $folder->notify_before)
                {
                    $user = $folder->user;
                    $company = User::with('company')->find($user->id)->company;

                    $user->notify(new FolderDueDateNotification($folder));

                    if(filled($company))
                    {
                        if(filled($company->smtp))
                        {
                            $this->configureSmtp($company->smtp);
                        }
                    }

                    Config::set('app.name', $company->name ?? env('APP_NAME'));

                    $data = [
                        'from_email' => $company->email ?? config('mail.from.address'),
                        'from_name' => $company->name ?? config('mail.from.name'),
                        'to_email' => $user->email,
                        'to_name' => $user->full_name,
                        'folder_name' => $folder->title,
                        'remaining_days' => $days
                    ];

                    Mail::to($user->email)->send(new FolderDueDate($data));
                }
            }
        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
        }
    }

    public function configureSmtp(array $smtp): void
    {
        Config::set('mail.mailers.smtp.encryption', $smtp['encryption']);
        Config::set('mail.mailers.smtp.host', $smtp['host']);
        Config::set('mail.mailers.smtp.port', $smtp['port']);
        Config::set('mail.mailers.smtp.username', $smtp['username']);
        Config::set('mail.mailers.smtp.password', $smtp['password']);
    }
}
