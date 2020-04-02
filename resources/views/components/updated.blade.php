<p class="text-muted">
    {{ empty(trim($slot)) ? 'Added: ' : $slot }} {{ $date->diffForHumans() }}<br/>
  
    @if(isset($name))
        by: {{ $name }}
    @endif
</p>
