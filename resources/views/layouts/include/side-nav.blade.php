@auth
<div class="h-100 d-flex flex-column">
    <header class="side-nav-header">

        {{-- Logo --}}
        <div class="px-3 pt-3">
            <span class="navbar-brand">
                <img src="{{ asset('/img/logo.png') }}" /> {{ Config::get('app.name') }}
            </span>
        </div>

        {{-- Navigation --}}
        <ul class="nav flex-column nav-pills my-3 mt-0">
            @foreach ($nav as $n)
                @if ($n->isAuthorized())
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is($n->getActive()) ? 'active' : '' }}" href="{{ $n->getRoute() }}">
                            <i class="fa fa-{{ $n->getIcon() }}" title="{{ $n->getCaption() }}"></i> {{ $n->getCaption() }}
                            @if ($n->getBadge() != null)
                                <span class="badge badge-secondary ml-2">{{ $n->getBadge() }}</span>
                            @endif
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>

    </header>

    {{-- Footer --}}
    <footer class="side-nav-footer">

        <hr>
        <div class="text-center">
            <a href="{{ route('userprofile') }}">
                <img src="{{ Auth::user()->avatarUrl() }}" alt="Gravatar" style="width: 80px; height: 80px;">
            </a><br>
            {{ Auth::user()->name }}
        </div>

        {{-- Logout --}}
        <div class="px-3 mt-3">
            <form class="form-inline" action="{{ route('logout') }}" method="POST">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-block btn-secondary">@icon(sign-out-alt) @lang('app.logout')</button>
            </form>
        </div>

        <hr>
        <p class="copyright text-muted px-3">
            <a href="{{ Config::get('app.product_url') }}" target="_blank" class="text-dark">{{ Config::get('app.product_name') }}</a>
            @if(is_module_enabled('Changelog'))
                <a href="{{ route('changelog') }}">{{ $app_version }}</a><br>
            @else
                {{ $app_version }}<br>
            @endif
            &copy; Nicolas Perrenoud<br>
            Page rendered in {{ round((microtime(true) - LARAVEL_START)*1000) }} ms
        </p>
    </footer>
</div>
@endauth