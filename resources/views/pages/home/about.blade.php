<section id="about" class="section">
    <div class="hgroup">
        <h3>Who am I</h3>
        <h2 title="About">About</h2>
    </div>
    <div class="row">
        <div class="col-md-4">
            <img src="{{ url('img/avatar.min.png') }}" class="img-responsive" />
        </div>
        <div class="col-md-8">
            <strong class="text-muted">Tom Witkowski</strong>
            <h4>
                Web <span class="text-primary">Developer</span> and <span class="text-primary">Gamer</span> from Hamburg
            </h4>
            <p>
                Moin <small class="text-muted">north-german greeting</small>,
                <br/>
                I'm a mid-twenty enthusiastic web developer and free time gamer from Hamburg, Germany. My core programming language is PHP but also JavaScript and a bit C# and Java.
                <br/>
                I've developed some <a class="smooth" href="#projects">packages</a> for Laravel/Lumen and host some WordPress, Symfony2 and Laravel pages.
            </p>
            <p>
                In my free time I try to create simple <a class="smooth" href="#games">games</a> with JavaScript or Unity3D and join the GameJams at InnoGames in Hamburg. I'm also interested in mountain biking and train for a triathlon.
            </p>

            <div class="row">
                <div class="col-md-4 font-montserrat">
                    <i class="icon fa-github fa-4x pull-left margin-right-15"></i>
                    <strong class="text-uppercase">Contribute</strong>
                    <br/>
                    <span class="count-to font-size-2em text-primary" data-from="0" data-to="{{ $contribute }}" data-speed="2000">{{ $contribute }}</span>
                </div>
                <div class="col-md-4 font-montserrat">
                    <i class="icon fa-steam fa-4x pull-left margin-right-15"></i>
                    <strong class="text-uppercase">Playtime</strong>
                    <br/>
                    <span class="count-to font-size-2em text-primary" data-from="0" data-to="{{ $playtime }}" data-speed="2000">{{ $playtime }}</span>
                </div>
                <div class="col-md-4 font-montserrat">
                    <i class="icon fa-gamepad fa-4x pull-left margin-right-15"></i>
                    <strong class="text-uppercase">GameJams</strong>
                    <br/>
                    <span class="count-to font-size-2em text-primary" data-from="0" data-to="9" data-speed="2000">9</span>
                </div>
            </div>
        </div>
    </div>
</section>