
<x-mail::message>
# New Property Added!

A new property has been added to the system and is now available for viewing.

**Property Title:** {{ $property->title }}
**Location:** {{ $property->location }}
**Price:** ${{ number_format($property->price) }}

<x-mail::button :url="url('/properties/'.$property->id)">
View Property Details
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>