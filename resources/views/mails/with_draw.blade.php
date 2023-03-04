<x-mail::message>
    <x-mail::header :url="$url">
        {{ $type_message }}
        <br>
        {{ $amount_message }}
        <x-mail::button :url="$url" color="success">
        عرض  تفاصيل العمليه
        </x-mail::button>
        {{ date('Y-M-D H:I:S') }}

        {{ config('app.name') }}
    </x-mail::header>


</x-mail::message>
