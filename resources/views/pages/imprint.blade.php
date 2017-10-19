@extends('master')

@section('menu')
<ul class="nav navbar-nav">
    <li>
        <a href="{{ url('/') }}">Home</a>
    </li>
    <li class="active">
        <a href="{{ url('imprint') }}">Imprint</a>
    </li>
    <li>
        <a href="{{ url('privacy') }}">Privacy</a>
    </li>
</ul>
@endsection

@section('content')
<section class="section">
    <div class="hgroup">
        <h3>Legal Disclosure</h3>
        <h2 title="Imprint">Imprint</h2>
    </div>
    <h4>Information in accordance with section 5 TMG</h4>
    <p>
        Tom Witkowski<br/>
        Benzenbergweg 3<br/>
        22307 Hamburg
    </p>

    <h4>Contact</h4>
    <ul class="list-unstyled">
        <li>
            <strong>Telephone</strong>
            +49 162 1525105
        </li>
        <li>
            <strong>E-Mail</strong>
            dev.gummibeer@gmail.com
        </li>
    </ul>

    <h4>Disclaimer</h4>
    <h5>Accountability for content</h5>
    <p>The contents of my pages have been created with the utmost care. However, I cannot guarantee the contents' accuracy, completeness or topicality. According to statutory provisions, I am furthermore responsible for my own content on these web pages. In this context, please note that I am accordingly not obliged to monitor merely the transmitted or saved information of third parties, or investigate circumstances pointing to illegal activity. My obligations to remove or block the use of information under generally applicable laws remain unaffected by this as per §§ 8 to 10 of the Telemedia Act (TMG).</p>

    <h5>Accountability for links</h5>
    <p>Responsibility for the content of external links (to web pages of third parties) lies solely with the operators of the linked pages. No violations were evident to me at the time of linking. Should any legal infringement become known to me, I will remove the respective link immediately.</p>

    <h5>Copyright</h5>
    <p>My web pages and their contents are subject to German copyright law. Unless expressly permitted by law (§ 44a et seq. of the copyright law), every form of utilizing, reproducing or processing works subject to copyright protection on my web pages requires the prior consent of the respective owner of the rights. Individual reproductions of a work are allowed only for private use, so must not serve either directly or indirectly for earnings. Unauthorized utilization of copyrighted works is punishable (§ 106 of the copyright law).</p>
</section>
@endsection