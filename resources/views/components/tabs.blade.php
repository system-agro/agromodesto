<ul class="nav nav-tabs" id="customTabs" role="tablist">
    @foreach ($tabs as $tab)
    <li class="nav-item">
        <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $tab['id'] }}-tab" data-toggle="tab" role="tab" aria-controls="{{ $tab['id'] }}"
        data-route="{{ route($tab['routeName']) }}" onclick="{{ $tab['selectFunction'] }}()">{{ $tab['title'] }}</a>
    </li>
    @endforeach
</ul>

<div class="tab-content">
    @foreach ($tabs as $tab)
    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $tab['id'] }}" role="tabpanel" aria-labelledby="{{ $tab['id'] }}-tab"></div>
    @endforeach
</div>
