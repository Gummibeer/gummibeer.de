<section id="projects" class="section">
    <div class="hgroup">
        <h3>What I do</h3>
        <h2 title="Projects">Projects</h2>
    </div>
    <div class="well">
        <div class="row">
            <div class="col-sm-3 col-xs-6 text-center">
                <span data-toggle="tooltip" data-title="Downloads">
                    <i class="icon far fa-download text-muted margin-right-3"></i>
                    {{ number_format(collect($packages)->sum('downloads.total'), 0, '', '.') }}
                </span>
            </div>
            <div class="col-sm-3 col-xs-6 text-center">
                <span data-toggle="tooltip" data-title="Stars">
                    <i class="icon far fa-star text-muted margin-right-3"></i>
                    {{ number_format(collect($packages)->sum('favers'), 0, '', '.') }}
                </span>
            </div>
            <div class="col-sm-3 col-xs-6 text-center">
                <span data-toggle="tooltip" data-title="Watchers">
                    <i class="icon far fa-eye text-muted margin-right-3"></i>
                    {{ number_format(collect($packages)->sum('github_watchers'), 0, '', '.') }}
                </span>
            </div>
            <div class="col-sm-3 col-xs-6 text-center">
                <span data-toggle="tooltip" data-title="Dependents">
                    <i class="icon far fa-link text-muted margin-right-3"></i>
                    {{ number_format(collect($packages)->sum('dependents'), 0, '', '.') }}
                </span>
            </div>
        </div>
    </div>
    <div class="row masonry-container">
        @foreach(collect($packages)->sortByDesc('downloads.total')->values() as $package)
        <div class="col-sm-6 col-md-4 col-xs-12 masonry-item">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <small>{{ $package['vendor'] }}</small>
                    <h3 class="panel-title">{{ $package['title'] }}</h3>
                </div>
                @if(!empty($package['description']))
                <div class="panel-body">
                    {{ $package['description'] }}
                </div>
                @endif
                <div class="panel-footer padding-vertical-10">
                    <i class="icon fab fa-github text-muted margin-right-3"></i>
                    {{ ucfirst($package['role']) }}
                </div>
                <div class="panel-footer padding-vertical-10">
                    <ul class="list-inline margin-0">
                        <li class="margin-0">
                            <strong class="text-muted">{{ $package['language'] }}</strong>
                        </li>
                        <li class="margin-0">
                            <i class="icon far fa-download text-muted margin-right-3"></i>
                            {{ number_format($package['downloads']['total'], 0, '', '.') }}
                        </li>
                        <li class="margin-0">
                            <i class="icon far fa-star text-muted margin-right-3"></i>
                            {{ number_format($package['favers'], 0, '', '.') }}
                        </li>
                    </ul>
                </div>
                <div class="panel-footer text-center">
                    <a href="{{ $package['repository'] }}" target="_blank" rel="noopener noreferrer">
                        <i class="icon fab fa-github fa-2x"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
