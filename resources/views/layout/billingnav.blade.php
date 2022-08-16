<!-- Dashboard card navigation-->
<ul class="nav nav-tabs card-header-tabs">
    <li class="nav-item">
        <a class="nav-link {{(request()->is('billingFiles')) ? 'active' : ""}}" aria-current="page" href="{{url('billingFiles')}}">
            Statement of Accounts
{{--            <span class="badge bg-danger">{{$soaCount}}</span>--}}
        </a>
    </li>

    @if($unknownCount > 0)
    <li class="nav-item position-relative">
        <a class="nav-link {{(request()->is('billingUnknown','unknownSearch')) ? 'active' : ""}}" aria-current="page" href="{{url('billingUnknown')}}">
            Unknown <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                                            <span class="visually-hidden">New alerts</span>
                                            </span>
        </a>
    </li>
    @endif

    @if($duplicateCount > 0)
    <li class="nav-item position-relative">
        <a class="nav-link {{(request()->is('billingDuplicate')) ? 'active' : ""}}" aria-current="page" href="{{url('billingDuplicate')}}">
            Duplicate <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                                            <span class="visually-hidden">New alerts</span>
                                            </span>
        </a>
    </li>
    @endif

    @if($removedCount > 0)
    <li class="nav-item position-relative">
        <a class="nav-link {{(request()->is('billingRemoved')) ? 'active' : ""}}" aria-current="page" href="{{url('billingRemoved')}}">
            Removed <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                                            <span class="visually-hidden">New alerts</span>
                                            </span>
{{--            <span class="badge bg-danger">{{count($deletedFiles)}}</span>--}}
        </a>
    </li>
    @endif

{{--<!--    <li class="nav-item">--}}
{{--        <a class="nav-link {{(request()->is('billingRemoved')) ? 'active' : ""}}" aria-current="page" href="{{url('billingRemoved')}}">--}}
{{--            Unmatched--}}
{{--            {{&#45;&#45;            <span class="badge bg-danger">{{count($deletedFiles)}}</span>&#45;&#45;}}--}}
{{--        </a>--}}
{{--    </li>-->--}}
</ul>
