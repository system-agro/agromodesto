<div id="tabs">
    <ul class="nav nav-tabs" id="customTabs" role="tablist">
        @foreach ($tabsConfig as $tab)
            <li class="nav-item">
                <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $tab['id'] }}-tab" data-toggle="tab" role="tab"
                    aria-controls="{{ $tab['id'] }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                    data-route="{{ route($tab['routeName']) }}">{{ $tab['title'] }}</a>
            </li>
        @endforeach
    </ul>
</div>

