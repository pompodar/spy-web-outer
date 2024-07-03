@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Spy Online')
<img src="https://spy.blobsandtrees.online/android-chrome-512x512.png" class="logo" style="border-radius: 50%; width: 150px; height: 150px; max-height: 150px;" alt="Laravel Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
