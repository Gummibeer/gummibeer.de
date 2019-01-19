<section id="projects" class="section">
    <div class="hgroup">
        <h3>What I do</h3>
        <h2 title="Projects">Projects</h2>
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
                <div class="panel-footer">
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