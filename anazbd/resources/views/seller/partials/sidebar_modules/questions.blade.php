<li class="{{ strpos($routeName, 'seller.questions') === 0 ? 'open active' : ''}}">
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon fa fa-question"></i></i>
        <span class="menu-text">
                    Question
                </span>
        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>
    <ul class="submenu">
        <li class="{{ strpos($routeName, 'seller.questions.answered') === 0 ? 'open' : ''}}">
            <a href="{{route('seller.questions.answered')}}">
                <i class="menu-icon fa fa-caret-right"></i>
                Answered
            </a>
            <b class="arrow"></b>
        </li>
        <li class="{{ strpos($routeName, 'seller.questions.unanswered') === 0 ? 'open' : ''}}">
            <a href="{{route('seller.questions.unanswered')}}">
                <i class="menu-icon fa fa-caret-right"></i>
                Unanswered
            </a>
            <b class="arrow"></b>
        </li>
    </ul>
</li>