@extends('master')

@section('menu')
<ul class="nav navbar-nav">
    <li>
        <a href="{{ url('/') }}">Home</a>
    </li>
    <li>
        <a href="{{ url('imprint') }}">Imprint</a>
    </li>
    <li class="active">
        <a href="{{ url('privacy') }}">Privacy</a>
    </li>
</ul>
@endsection

@section('content')
<section class="section">
    <div class="hgroup">
        <h3>Privacy Statement</h3>
        <h2 title="Privacy">Privacy</h2>
    </div>
    <p>
        <strike>Nothing. Really, for this website I collect <strong>nothing</strong> about you.</strike>
    </p>
    <p>
        Following the GDPR (General Data Protection Regulation) I now have to tell you what data is collected by pages I link to and tools I use. So I don't save anything about you, because your privacy is important for me and there is no reason for.
    </p>
    <div>
        <h4>Cookies</h4>
        <p>Believe it or not - I do not use cookies. There is nothing I want to track with them or optimize. My page is static and that is it.</p>

        <h4>Collection of general data and information</h4>
        <p>I do not collect anything about you or your system - not even any server logs with your IP-Address. But to be real, your IP-Address, Browser-Version and things like this are transported to my server and some of these information are processed during the request. But they are not stored after this.</p>

        <h4>Routine erasure and blocking of personal data</h4>
        <p>Because of the fact that I do not save anything I can not save anything longer than necessary.</p>

        <h4>Rights of the data subject</h4>
        <p>You are allowed to ask me anytime what I have saved and know about you and also tell me to delete everything. Like said above - in both cases I can not tell you anything about you or delete something what is not present.</p>

        <h4>Linking to foreign pages</h4>
        <p>Primary in the footer section but also some other places I link to other pages like Facebook, Google+, Youtube, Xing and so on. I can not tell you what data they collect and what they do with them - please refer to the privacy statements of the linked page to find these information.</p>

        <h4>Google Fonts</h4>
        <p>I use Google Fonts but not directly - so your browser loads the fonts from my server. So there is no other privacy related thing - but I want you to honor the work done by the Google Fonts team to bring beautiful fonts to the web.</p>

        <h4>Font Awesome</h4>
        <p>I use Font Awesome Pro but not directly - so your browser loads the fonts from my server. So there is no other privacy related thing - but I want you to honor the work done by the Font Awesome team to bring beautiful icons to the web.</p>
    </div>
</section>
@endsection