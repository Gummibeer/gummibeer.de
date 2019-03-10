<ul class="social-list">
    @foreach(social_links() as $type => $socialLink)
        <li>
            <a href="{{ $socialLink['href'] }}" target="_blank" rel="noopener noreferrer" class="social-{{ $type }}" data-toggle="tooltip" title="{{ $socialLink['title'] }}">
                <i class="{{ $socialLink['icon'] }}"></i>
            </a>
        </li>
    @endforeach
</ul>
