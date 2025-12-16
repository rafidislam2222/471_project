<x-mail::message>
# New Property Alert!

A new property has just been listed: **{{ $property->title }}**

## Rent: ${{ number_format($property->rent_price) }}

**Address:** {{ $property->address }}

{{ Str::limit($property->description, 100) }}

<x-mail::button :url="url('/properties/' . $property->id)">
View Property Details
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>