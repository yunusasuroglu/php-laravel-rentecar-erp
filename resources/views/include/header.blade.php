        <!-- app-header -->
        @if (auth()->user()->company_id == !null)
        <header style="background-color: #1d74f5 !important;" class="app-header">
            
            <!-- Start::main-header-container -->
            <div class="main-header-container container-fluid">
                
                <!-- Start::header-content-left -->
                <div class="header-content-left">
                    
                    <!-- Start::header-element -->
                    <div class="header-element">
                        <div class="horizontal-logo">
                            <a href="{{route('home')}}" class="header-logo">
                                <img style="width: 80%;" src="{{asset('/')}}{{ Auth::user()->company->logo ?? 'assets/images/default/default-logo.png'}}" alt="{{ Auth::user()->company->name ?? trans_dynamic('header_not_company')}}" class="desktop-dark">
                                <img style="width: 40px; height: 40px;" src="{{asset('/')}}{{ Auth::user()->company->profile_image ?? 'assets/images/default/default-profile.png'}}" alt="{{ Auth::user()->company->name ?? trans_dynamic('header_not_company')}}" class="toggle-dark">
                            </a>
                        </div>
                    </div>
                    <!-- End::header-element -->
                    
                    <!-- Start::header-element -->
                    <div class="header-element">
                        <!-- Start::header-link -->
                        <a aria-label="anchor" href="javascript:void(0);" class="sidemenu-toggle header-link" data-bs-toggle="sidebar">
                            <span class="open-toggle me-2">
                                <i class="bx bx-menu header-link-icon"></i>
                            </span>
                        </a>
                        <!-- End::header-link -->
                    </div>
                    <!-- End::header-element -->
                    
                    <!-- Start::header-element -->
                    <div class="header-element header-search d-lg-none d-block ">
                        <!-- Start::header-link -->
                        <a aria-label="anchor" href="javascript:void(0);" class="header-link" data-bs-toggle="modal" data-bs-target="#searchModal">
                            <i class="bx bx-search-alt-2 header-link-icon"></i>
                        </a>
                        <!-- End::header-link -->
                    </div>
                    <!-- End::header-element -->
                    
                </div>
                <!-- End::header-content-left -->
                
                <!-- Start::header-content-right -->
                <div class="header-content-right">
                    
                    <!-- Start::header-element -->
                    <div class="header-element country-selector">
                        <!-- Start::header-link|dropdown-toggle -->
                        <a aria-label="anchor" href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            <i class="bx bx-globe header-link-icon"></i>
                        </a>
                        <!-- End::header-link|dropdown-toggle -->
                        <ul class="main-header-dropdown dropdown-menu border-0" data-popper-placement="none">
                            @foreach ($languages as $language)
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('change.language', $language->code) }}">
                                    <span class="avatar avatar-xs lh-1 me-2">
                                        <img src="{{asset('/')}}{{$language->logo}}" alt="img">
                                    </span>
                                    {{ $language->name }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- End::header-element -->
                    
                    <!-- Start::header-element -->
                    {{-- <div class="header-element notifications-dropdown ">
                        <!-- Start::header-link|dropdown-toggle -->
                        <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" id="messageDropdown" aria-expanded="false">
                            <i class="bx bx-bell bx-flip-horizontal header-link-icon ionicon"></i>
                            <span class="badge bg-info rounded-pill header-icon-badge pulse pulse-secondary" id="notification-icon-badge">5</span>
                        </a>
                        <!-- End::header-link|dropdown-toggle -->
                        <!-- Start::main-header-dropdown -->
                        <div class="main-header-dropdown dropdown-menu  border-0 dropdown-menu-end" data-popper-placement="none">
                            <div class="p-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <p class="mb-0 fs-17 fw-semibold">{{ trans_dynamic('header_notifications') }}</p>
                                    <span class="badge bg-secondary-transparent" id="notifiation-data">5 {{ trans_dynamic('header_notifications_unread') }}</span>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <ul class="list-unstyled mb-0" id="header-notification-scroll">
                                <li class="dropdown-item">
                                    <div class="d-flex align-items-start">
                                        <div class="pe-2">
                                            <span class="avatar avatar-md bg-secondary-transparent rounded-2">
                                                <img src="../assets/images/faces/2.jpg" alt="">
                                            </span>
                                        </div>
                                        <div class="flex-grow-1 d-flex  justify-content-between">
                                            <div>
                                                <p class="mb-0 fw-semibold"><a href="notifications.html">Olivia James</a></p>
                                                <span class="fs-12 text-muted fw-normal">Congratulate for New template start</span>
                                            </div>
                                            <div class="min-w-fit-content ms-2 text-end">
                                                <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit-content text-muted me-1 dropdown-item-close1"><i class="ti ti-x fs-14"></i></a>
                                                <p class="mb-0 text-muted fs-11">2 min ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown-item">
                                    <div class="d-flex align-items-start">
                                        <div class="pe-2">
                                            <span class="avatar avatar-md bg-warning-transparent rounded-2"><i class="bx bx-pyramid fs-18"></i></span>
                                        </div>
                                        <div class="flex-grow-1 d-flex  justify-content-between">
                                            <div>
                                                <p class="mb-0 fw-semibold"><a href="notifications.html">Order Placed <span class="text-warning">ID: #1116773</span></a></p>
                                                <span class="fs-12 text-muted fw-normal header-notification-text">Order Placed Successfully</span>
                                            </div>
                                            <div class="min-w-fit-content ms-2 text-end">
                                                <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit-content text-muted me-1 dropdown-item-close1"><i class="ti ti-x fs-14"></i></a>
                                                <p class="mb-0 text-muted fs-11">5 min ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown-item">
                                    <div class="d-flex align-items-start">
                                        <div class="pe-2">
                                            <span class="avatar avatar-md bg-secondary-transparent rounded-2">
                                                <img src="../assets/images/faces/8.jpg" alt="">
                                            </span>
                                        </div>
                                        <div class="flex-grow-1 d-flex  justify-content-between">
                                            <div>
                                                <p class="mb-0 fw-semibold"><a href="notifications.html">Elizabeth Lewis</a></p>
                                                <span class="fs-12 text-muted fw-normal">added new schedule realease date</span>
                                            </div>
                                            <div class="min-w-fit-content ms-2 text-end">
                                                <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit-content text-muted me-1 dropdown-item-close1"><i class="ti ti-x fs-14"></i></a>
                                                <p class="mb-0 text-muted fs-11">10 min ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown-item">
                                    <div class="d-flex align-items-start">
                                        <div class="pe-2">
                                            <span class="avatar avatar-md bg-primary-transparent rounded-2"><i class="bx bx-pulse fs-18"></i></span>
                                        </div>
                                        <div class="flex-grow-1 d-flex  justify-content-between">
                                            <div>
                                                <p class="mb-0 fw-semibold"><a href="notifications.html">Your Order Has Been Shipped</a></p>
                                                <span class="fs-12 text-muted fw-normal header-notification-text">Order No: 123456 Has Shipped To Your Delivery Address</span>
                                            </div>
                                            <div class="min-w-fit-content ms-2 text-end">
                                                <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit-content text-muted me-1 dropdown-item-close1"><i class="ti ti-x fs-14"></i></a>
                                                <p class="mb-0 text-muted fs-11">12 min ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown-item">
                                    <div class="d-flex align-items-start">
                                        <div class="pe-2">
                                            <span class="avatar avatar-md bg-pink-transparent rounded-2"><i class="bx bx-badge-check"></i></span>
                                        </div>
                                        <div class="flex-grow-1 d-flex  justify-content-between">
                                            <div>
                                                <p class="mb-0 fw-semibold"><a href="notifications.html">Account Has Been Verified</a></p>
                                                <span class="fs-12 text-muted fw-normal  header-notification-text">Your Account Has Been Verified Sucessfully</span>
                                            </div>
                                            <div class="min-w-fit-content ms-2 text-end">
                                                <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit-content text-muted me-1 dropdown-item-close1"><i class="ti ti-x fs-14"></i></a>
                                                <p class="mb-0 text-muted fs-11">20 min ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="p-3 empty-header-item1 border-top">
                                <div class="d-grid">
                                    <a href="notifications.html" class="btn btn-primary">View All</a>
                                </div>
                            </div>
                            <div class="p-5 empty-item1 d-none">
                                <div class="text-center">
                                    <span class="avatar avatar-xl avatar-rounded bg-secondary-transparent">
                                        <i class="bx bx-bell-off bx-tada fs-2"></i>
                                    </span>
                                    <h6 class="fw-semibold mt-3">No New Notifications</h6>
                                </div>
                            </div>
                        </div>
                        <!-- End::main-header-dropdown -->
                    </div> --}}
                    <!-- End::header-element -->
                    <div class="header-element d-flex header-settings header-shortcuts-dropdown">
                        <a aria-label="anchor" href="javascript:void(0);" class=" header-link nav-link icon" data-bs-toggle="offcanvas" data-bs-target="#apps" aria-controls="apps">
                            <i class="bx bx-category  header-link-icon"></i>
                        </a>
                    </div>
                    
                    <div class="offcanvas offcanvas-end wd-330" tabindex="-1" id="apps" aria-labelledby="appsLabel">
                        <div class="offcanvas-header border-bottom">
                            <h5 id="appsLabel" class="mb-0 fs-18">{{ trans_dynamic('fast_access') }}</h5>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"> <i class="bx bx-x apps-btn-close"></i></button>
                        </div>
                        <div class="p-3">
                            <div class="row g-3">
                                <div class="col-6">
                                    <a href="{{ route('profile.edit') }}" class="nav-link">
                                        <div class="text-center p-3 related-app border">
                                            <span class="avatar bg-warning-transparent fs-23 bg p-2 mb-2">
                                                <i class="bx bx-user  text-warning"></i>
                                            </span>
                                            <span class="d-block fs-13 text-muted fw-semibold">{{ trans_dynamic('profile') }}</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('customers') }}" class="nav-link">
                                        <div class="text-center p-3 related-app border">
                                            <span class="avatar bg-primary-transparent fs-23 bg p-2 mb-2">
                                                <i class="bx bxs-user-detail  text-primary"></i>
                                            </span>
                                            <span class="d-block fs-13 text-muted fw-semibold">{{ trans_dynamic('customers') }}</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('cars') }}" class="nav-link">
                                        <div class="text-center p-3 related-app border">
                                            <span class="avatar bg-success-transparent fs-23 bg p-2 mb-2">
                                                <i class="bx bx-car  text-success"></i>
                                            </span>
                                            <span class="d-block fs-13 text-muted fw-semibold">{{ trans_dynamic('cars') }}</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('contracts') }}" class="nav-link">
                                        <div class="text-center p-3 related-app border">
                                            <span class="avatar bg-danger-transparent fs-23 bg p-2 mb-2">
                                                <i class="bx bx-receipt  text-danger"></i>
                                            </span>
                                            <span class="d-block fs-13 text-muted fw-semibold">{{ trans_dynamic('contracts') }}</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('calender') }}" class="nav-link">
                                        <div class="text-center p-3 related-app border">
                                            <span class="avatar bg-danger-transparent fs-23 bg p-2 mb-2">
                                                <i class="bx bx-receipt  text-danger"></i>
                                            </span>
                                            <span class="d-block fs-13 text-muted fw-semibold">{{ trans_dynamic('calender') }}</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('invoices') }}" class="nav-link">
                                        <div class="text-center p-3 related-app border">
                                            <span class="avatar bg-danger-transparent fs-23 bg p-2 mb-2">
                                                <i class="bx bx-receipt  text-danger"></i>
                                            </span>
                                            <span class="d-block fs-13 text-muted fw-semibold">{{ trans_dynamic('invoices') }}</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('punishments') }}" class="nav-link">
                                        <div class="text-center p-3 related-app border">
                                            <span class="avatar bg-danger-transparent fs-23 bg p-2 mb-2">
                                                <i class="bx bx-receipt  text-danger"></i>
                                            </span>
                                            <span class="d-block fs-13 text-muted fw-semibold">{{ trans_dynamic('punishments') }}</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Start::header-element -->
                    
                    <!-- Start::header-element -->
                    <div class="header-element mainuserProfile">
                        <!-- Start::header-link|dropdown-toggle -->
                        <a href="javascript:void(0);" class="header-link dropdown-toggle" id="mainHeaderProfile" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <div class="d-sm-flex wd-100p">
                                    <div class="avatar avatar-sm"><img alt="{{ Auth::user()->name }} {{ Auth::user()->surname }} - {{ Auth::user()->company->name ?? trans_dynamic('header_not_company')}}" class="rounded-circle" src="{{asset('/')}}{{ Auth::user()->profile_image }}"></div>
                                    <div class="ms-2 my-auto d-none d-xl-flex">
                                        <h6 class=" font-weight-semibold mb-0 fs-13 user-name d-sm-block d-none">{{ Auth::user()->name }}</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <!-- End::header-link|dropdown-toggle -->
                        <ul class="dropdown-menu  border-0 main-header-dropdown  overflow-hidden header-profile-dropdown" aria-labelledby="mainHeaderProfile">
                            <li><a class="dropdown-item" href="{{route('profile.edit')}}"><i class="fs-13 me-2 bx bx-user"></i>{{ trans_dynamic('profile') }}</a></li>
                            <li><a class="dropdown-item" href="{{route('company.profile')}}"><i class="fs-13 me-2 bx bx-user"></i>{{ trans_dynamic('company') }} {{ trans_dynamic('profile') }}</a></li>
                            <li><a class="dropdown-item" style="cursor: pointer;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fs-13 me-2 bx bx-arrow-to-right"></i>{{ trans_dynamic('logout') }}</a></li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </ul>
                    </div>
                </div>
                <!-- End::header-content-right -->
                
            </div>
            <!-- End::main-header-container -->
            
        </header>
        @else
        <header style="background-color: #1d74f5 !important;" class="app-header">
            
            <!-- Start::main-header-container -->
            <div class="main-header-container container-fluid">
                
                <!-- Start::header-content-left -->
                <div class="header-content-left">
                    
                    <!-- Start::header-element -->
                    <div class="header-element">
                        <div class="horizontal-logo">
                            <a href="{{route('home')}}" class="header-logo">
                                <img style="width: 80%;" src="{{asset('/assets/images/default/default-logo.png')}}" class="desktop-dark">
                                <img style="width: 40px; height: 40px;" src="{{asset('/assets/images/default/default-logo.png')}}" alt="Rent Soft" class="toggle-dark">
                            </a>
                        </div>
                    </div>
                    <!-- End::header-element -->
                    
                    <!-- Start::header-element -->
                    <div class="header-element">
                        <!-- Start::header-link -->
                        <a aria-label="anchor" href="javascript:void(0);" class="sidemenu-toggle header-link" data-bs-toggle="sidebar">
                            <span class="open-toggle me-2">
                                <i class="bx bx-menu header-link-icon"></i>
                            </span>
                        </a>
                        <!-- End::header-link -->
                    </div>
                    <!-- End::header-element -->
                    
                    <!-- Start::header-element -->
                    <div class="header-element header-search d-lg-none d-block ">
                        <!-- Start::header-link -->
                        <a aria-label="anchor" href="javascript:void(0);" class="header-link" data-bs-toggle="modal" data-bs-target="#searchModal">
                            <i class="bx bx-search-alt-2 header-link-icon"></i>
                        </a>
                        <!-- End::header-link -->
                    </div>
                    <!-- End::header-element -->
                    
                </div>
                <!-- End::header-content-left -->
                
                <!-- Start::header-content-right -->
                <div class="header-content-right">
                    
                    <!-- Start::header-element -->
                    <div class="header-element country-selector">
                        <!-- Start::header-link|dropdown-toggle -->
                        <a aria-label="anchor" href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            <i class="bx bx-globe header-link-icon"></i>
                        </a>
                        <!-- End::header-link|dropdown-toggle -->
                        <ul class="main-header-dropdown dropdown-menu border-0" data-popper-placement="none">
                            @foreach ($languages as $language)
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('change.language', $language->code) }}">
                                    <span class="avatar avatar-xs lh-1 me-2">
                                        <img src="{{asset('/')}}{{$language->logo}}" alt="img">
                                    </span>
                                    {{ $language->name }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- End::header-element -->
                    
                    {{-- <!-- Start::header-element -->
                    <div class="header-element notifications-dropdown ">
                        <!-- Start::header-link|dropdown-toggle -->
                        <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" id="messageDropdown" aria-expanded="false">
                            <i class="bx bx-bell bx-flip-horizontal header-link-icon ionicon"></i>
                            <span class="badge bg-info rounded-pill header-icon-badge pulse pulse-secondary" id="notification-icon-badge">5</span>
                        </a>
                        <!-- End::header-link|dropdown-toggle -->
                        <!-- Start::main-header-dropdown -->
                        <div class="main-header-dropdown dropdown-menu  border-0 dropdown-menu-end" data-popper-placement="none">
                            <div class="p-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <p class="mb-0 fs-17 fw-semibold">{{ trans_dynamic('header_notifications') }}</p>
                                    <span class="badge bg-secondary-transparent" id="notifiation-data">5 {{ trans_dynamic('header_notifications_unread') }}</span>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <ul class="list-unstyled mb-0" id="header-notification-scroll">
                                <li class="dropdown-item">
                                    <div class="d-flex align-items-start">
                                        <div class="pe-2">
                                            <span class="avatar avatar-md bg-secondary-transparent rounded-2">
                                                <img src="../assets/images/faces/2.jpg" alt="">
                                            </span>
                                        </div>
                                        <div class="flex-grow-1 d-flex  justify-content-between">
                                            <div>
                                                <p class="mb-0 fw-semibold"><a href="notifications.html">Olivia James</a></p>
                                                <span class="fs-12 text-muted fw-normal">Congratulate for New template start</span>
                                            </div>
                                            <div class="min-w-fit-content ms-2 text-end">
                                                <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit-content text-muted me-1 dropdown-item-close1"><i class="ti ti-x fs-14"></i></a>
                                                <p class="mb-0 text-muted fs-11">2 min ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown-item">
                                    <div class="d-flex align-items-start">
                                        <div class="pe-2">
                                            <span class="avatar avatar-md bg-warning-transparent rounded-2"><i class="bx bx-pyramid fs-18"></i></span>
                                        </div>
                                        <div class="flex-grow-1 d-flex  justify-content-between">
                                            <div>
                                                <p class="mb-0 fw-semibold"><a href="notifications.html">Order Placed <span class="text-warning">ID: #1116773</span></a></p>
                                                <span class="fs-12 text-muted fw-normal header-notification-text">Order Placed Successfully</span>
                                            </div>
                                            <div class="min-w-fit-content ms-2 text-end">
                                                <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit-content text-muted me-1 dropdown-item-close1"><i class="ti ti-x fs-14"></i></a>
                                                <p class="mb-0 text-muted fs-11">5 min ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown-item">
                                    <div class="d-flex align-items-start">
                                        <div class="pe-2">
                                            <span class="avatar avatar-md bg-secondary-transparent rounded-2">
                                                <img src="../assets/images/faces/8.jpg" alt="">
                                            </span>
                                        </div>
                                        <div class="flex-grow-1 d-flex  justify-content-between">
                                            <div>
                                                <p class="mb-0 fw-semibold"><a href="notifications.html">Elizabeth Lewis</a></p>
                                                <span class="fs-12 text-muted fw-normal">added new schedule realease date</span>
                                            </div>
                                            <div class="min-w-fit-content ms-2 text-end">
                                                <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit-content text-muted me-1 dropdown-item-close1"><i class="ti ti-x fs-14"></i></a>
                                                <p class="mb-0 text-muted fs-11">10 min ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown-item">
                                    <div class="d-flex align-items-start">
                                        <div class="pe-2">
                                            <span class="avatar avatar-md bg-primary-transparent rounded-2"><i class="bx bx-pulse fs-18"></i></span>
                                        </div>
                                        <div class="flex-grow-1 d-flex  justify-content-between">
                                            <div>
                                                <p class="mb-0 fw-semibold"><a href="notifications.html">Your Order Has Been Shipped</a></p>
                                                <span class="fs-12 text-muted fw-normal header-notification-text">Order No: 123456 Has Shipped To Your Delivery Address</span>
                                            </div>
                                            <div class="min-w-fit-content ms-2 text-end">
                                                <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit-content text-muted me-1 dropdown-item-close1"><i class="ti ti-x fs-14"></i></a>
                                                <p class="mb-0 text-muted fs-11">12 min ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown-item">
                                    <div class="d-flex align-items-start">
                                        <div class="pe-2">
                                            <span class="avatar avatar-md bg-pink-transparent rounded-2"><i class="bx bx-badge-check"></i></span>
                                        </div>
                                        <div class="flex-grow-1 d-flex  justify-content-between">
                                            <div>
                                                <p class="mb-0 fw-semibold"><a href="notifications.html">Account Has Been Verified</a></p>
                                                <span class="fs-12 text-muted fw-normal  header-notification-text">Your Account Has Been Verified Sucessfully</span>
                                            </div>
                                            <div class="min-w-fit-content ms-2 text-end">
                                                <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit-content text-muted me-1 dropdown-item-close1"><i class="ti ti-x fs-14"></i></a>
                                                <p class="mb-0 text-muted fs-11">20 min ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="p-3 empty-header-item1 border-top">
                                <div class="d-grid">
                                    <a href="notifications.html" class="btn btn-primary">View All</a>
                                </div>
                            </div>
                            <div class="p-5 empty-item1 d-none">
                                <div class="text-center">
                                    <span class="avatar avatar-xl avatar-rounded bg-secondary-transparent">
                                        <i class="bx bx-bell-off bx-tada fs-2"></i>
                                    </span>
                                    <h6 class="fw-semibold mt-3">No New Notifications</h6>
                                </div>
                            </div>
                        </div>
                        <!-- End::main-header-dropdown -->
                    </div>
                    <!-- End::header-element --> --}}
                    <div class="header-element d-flex header-settings header-shortcuts-dropdown">
                        <a aria-label="anchor" href="javascript:void(0);" class=" header-link nav-link icon" data-bs-toggle="offcanvas" data-bs-target="#apps" aria-controls="apps">
                            <i class="bx bx-category  header-link-icon"></i>
                        </a>
                    </div>
                    
                    <div class="offcanvas offcanvas-end wd-330" tabindex="-1" id="apps" aria-labelledby="appsLabel">
                        <div class="offcanvas-header border-bottom">
                            <h5 id="appsLabel" class="mb-0 fs-18">{{ trans_dynamic('fast_access') }}</h5>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"> <i class="bx bx-x apps-btn-close"></i></button>
                        </div>
                        <div class="p-3">
                            <div class="row g-3">
                                <div class="col-6">
                                    <a href="{{ route('profile.edit') }}" class="nav-link">
                                        <div class="text-center p-3 related-app border">
                                            <span class="avatar bg-warning-transparent fs-23 bg p-2 mb-2">
                                                <i class="bx bx-user  text-warning"></i>
                                            </span>
                                            <span class="d-block fs-13 text-muted fw-semibold">{{ trans_dynamic('profile') }}</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('companies') }}" class="nav-link">
                                        <div class="text-center p-3 related-app border">
                                            <span class="avatar bg-primary-transparent fs-23 bg p-2 mb-2">
                                                <i class="bx bxs-user-detail  text-primary"></i>
                                            </span>
                                            <span class="d-block fs-13 text-muted fw-semibold">{{ trans_dynamic('companies') }}</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('users') }}" class="nav-link">
                                        <div class="text-center p-3 related-app border">
                                            <span class="avatar bg-success-transparent fs-23 bg p-2 mb-2">
                                                <i class="bx bx-car  text-success"></i>
                                            </span>
                                            <span class="d-block fs-13 text-muted fw-semibold">{{ trans_dynamic('users') }}</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('languages') }}" class="nav-link">
                                        <div class="text-center p-3 related-app border">
                                            <span class="avatar bg-danger-transparent fs-23 bg p-2 mb-2">
                                                <i class="bx bx-receipt  text-danger"></i>
                                            </span>
                                            <span class="d-block fs-13 text-muted fw-semibold">{{ trans_dynamic('languages') }}</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Start::header-element -->
                    
                    <!-- Start::header-element -->
                    <div class="header-element mainuserProfile">
                        <!-- Start::header-link|dropdown-toggle -->
                        <a href="javascript:void(0);" class="header-link dropdown-toggle" id="mainHeaderProfile" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <div class="d-sm-flex wd-100p">
                                    <div class="avatar avatar-sm"><img alt="{{ Auth::user()->name }} {{ Auth::user()->surname }} - {{ Auth::user()->company->name ?? trans_dynamic('header_not_company')}}" class="rounded-circle" src="{{asset('/')}}{{ Auth::user()->profile_image }}"></div>
                                    <div class="ms-2 my-auto d-none d-xl-flex">
                                        <h6 class=" font-weight-semibold mb-0 fs-13 user-name d-sm-block d-none">{{ Auth::user()->name }}</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <!-- End::header-link|dropdown-toggle -->
                        <ul class="dropdown-menu  border-0 main-header-dropdown  overflow-hidden header-profile-dropdown" aria-labelledby="mainHeaderProfile">
                            <li><a class="dropdown-item" href="{{route('profile.edit')}}"><i class="fs-13 me-2 bx bx-user"></i>{{ trans_dynamic('profile') }}</a></li>
                            <li><a class="dropdown-item" style="cursor: pointer;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fs-13 me-2 bx bx-arrow-to-right"></i>{{ trans_dynamic('logout') }}</a></li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </ul>
                    </div>
                </div>
                <!-- End::header-content-right -->
                
            </div>
            <!-- End::main-header-container -->
            
        </header>
        @endif
        <!-- /app-header -->