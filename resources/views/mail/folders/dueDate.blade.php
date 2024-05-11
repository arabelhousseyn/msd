<x-mail::message>
{{trans('folder.message', ['folder_name' => $data['folder_name']])}}
Merci,<br>
{{ config('app.name') }}
</x-mail::message>
