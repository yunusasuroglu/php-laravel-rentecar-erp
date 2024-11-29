        <!-- Start::app-sidebar -->
        @if (auth()->user()->company_id == !null)
        <aside class="app-sidebar sticky" id="sidebar">
            
            <!-- Start::main-sidebar-header -->
            <div class="main-sidebar-header">
                <a href="{{route('home')}}" class="header-logo">
                    <img style="width: 80%;" src="{{asset('/')}}{{ Auth::user()->company->logo ?? 'assets/images/default/default-logo.png'}}" alt="{{ Auth::user()->company->name ?? 'Şirket Yok'}}" class="desktop-dark">
                    <img style="width: 40px; height: 40px;" src="{{asset('/')}}{{ Auth::user()->company->profile_image ?? 'assets/images/default/default-profile.png'}}" alt="{{ Auth::user()->company->name ?? 'Şirket Yok'}}" class="toggle-dark">
                </a>
            </div>
            <!-- End::main-sidebar-header -->
            
            <!-- Start::main-sidebar -->
            <div class="main-sidebar" id="sidebar-scroll">
                
                <!-- Start::nav -->
                <nav class="main-menu-container nav nav-pills flex-column sub-open">
                    <div class="slide-left" id="slide-left">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path> </svg>
                    </div>
                    <ul class="main-menu">
                        <!-- Start::slide__category -->
                        <li class="slide__category"><span class="category-name">{{trans_dynamic('main_menu')}}</span></li>
                        <!-- End::slide__category -->

                        <!-- Start::slide -->
                        <li class="slide">
                            <a href="{{route('home.company')}}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class="bx bx-desktop"></i>
                                </span>
                                <span class="side-menu__label">{{trans_dynamic('dashboard')}}</span>
                            </a>
                        </li>
                        <!-- End::slide -->
                        
                        <!-- Start::slide -->
                        <li class="slide">
                            <a href="{{route('calender')}}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class="bx bx-calendar"></i>
                                </span>
                                <span class="side-menu__label">{{trans_dynamic('calender')}}</span>
                            </a>
                        </li>
                        <!-- End::slide -->

                        <!-- Start::slide -->
                        <li class="slide has-sub">
                            <a href="javascript:void(0);" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class="bx bxs-car-garage"></i>
                                </span>
                                <span class="side-menu__label">{{trans_dynamic('cars')}}</span>
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child1">
                                <li class="slide side-menu__label1">
                                    <a href="javascript:void(0)">{{trans_dynamic('cars')}}</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('cars')}}" class="side-menu__item">{{trans_dynamic('cars')}}</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('cars.add')}}" class="side-menu__item">{{trans_dynamic('car_add')}}</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('cars.groups')}}" class="side-menu__item">{{trans_dynamic('car_groups')}}</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('cars.group.add')}}" class="side-menu__item">{{trans_dynamic('car_group_add')}}</a>
                                </li>
                            </ul>
                        </li>
                        <!-- End::slide -->
                        <!-- Start::slide -->
                        <li class="slide has-sub">
                            <a href="javascript:void(0);" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class="bx bxs-file-doc"></i>
                                </span>
                                <span class="side-menu__label">{{trans_dynamic('contracts')}}</span>
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child1">
                                <li class="slide side-menu__label1">
                                    <a href="javascript:void(0)">{{trans_dynamic('contracts')}}</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('contracts')}}" class="side-menu__item">{{trans_dynamic('contracts')}}</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('contracts.add')}}" class="side-menu__item">{{trans_dynamic('add_contract')}}</a>
                                </li>
                            </ul>
                        </li>
                        <!-- End::slide -->
                        
                        <!-- Start::slide -->
                        <li class="slide has-sub">
                            <a href="javascript:void(0);" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class="bx bx-euro"></i>
                                </span>
                                <span class="side-menu__label">{{trans_dynamic('invoices')}}</span>
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child1">
                                <li class="slide side-menu__label1">
                                    <a href="javascript:void(0)">{{trans_dynamic('invoices')}}</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('invoices')}}" class="side-menu__item">{{trans_dynamic('invoices')}}</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('invoices.manuel.add')}}" class="side-menu__item">{{trans_dynamic('invoice_add')}}</a>
                                </li>
                            </ul>
                        </li>
                        <!-- End::slide -->

                        <li class="slide has-sub">
                            <a href="javascript:void(0);" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class="bx bxs-id-card"></i>
                                </span>
                                <span class="side-menu__label">{{trans_dynamic('customers')}}</span>
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child1">
                                <li class="slide side-menu__label1">
                                    <a href="javascript:void(0)">{{trans_dynamic('customers')}}</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('customers')}}" class="side-menu__item">{{trans_dynamic('customers')}}</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('customers.add')}}" class="side-menu__item">{{trans_dynamic('customer_add')}}</a>
                                </li>
                            </ul>
                        </li>
                        <!-- Start::slide -->
                        <li class="slide has-sub">
                            <a href="javascript:void(0);" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class="bx bxs-user"></i>
                                </span>
                                <span class="side-menu__label">{{trans_dynamic('users')}}</span>
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child1">
                                <li class="slide side-menu__label1">
                                    <a href="javascript:void(0)">{{trans_dynamic('users')}}</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('persons')}}" class="side-menu__item">{{trans_dynamic('users')}}</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('persons.new')}}" class="side-menu__item">{{trans_dynamic('user_add')}}</a>
                                </li>
                            </ul>
                        </li>

                        <li class="slide has-sub">
                            <a href="javascript:void(0);" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class="bx bxs-cog"></i>
                                </span>
                                <span class="side-menu__label">{{trans_dynamic('settings')}}</span>
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child1">
                                <li class="slide side-menu__label1">
                                    <a href="javascript:void(0)">{{trans_dynamic('settings')}}</a>
                                </li>
                                <li class="slide">
                                    <a href="{{ route('company.profile.edit', ['id' => auth()->user()->company->id, 'reference_token' => auth()->user()->company->reference_token]) }}" class="side-menu__item">{{trans_dynamic('profile')}}</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('punishments')}}" class="side-menu__item">{{trans_dynamic('punishments')}}</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('company.punishment', auth()->user()->company->id)}}" class="side-menu__item">{{trans_dynamic('punishment_add')}}</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('company.mail.settings', auth()->user()->company->id)}}" class="side-menu__item">{{trans_dynamic('email')}}</a>
                                </li>
                            </ul>
                        </li>
                        <!-- End::slide -->
                    </ul>
                    <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path> </svg></div>
                </nav>
                <!-- End::nav -->
                
            </div>
            <!-- End::main-sidebar -->
            
        </aside>
        @else
        <aside class="app-sidebar sticky" id="sidebar">
            
            <!-- Start::main-sidebar-header -->
            <div class="main-sidebar-header">
                <a href="{{route('home')}}" class="header-logo">
                    <img style="width: 80%;" src="{{asset('/assets/images/default/default-logo.png')}}" alt="Rent Soft" class="desktop-dark">
                    <img style="width: 40px; height: 40px;" src="{{asset('/assets/images/default/default-logo.png')}}" alt="Rent Soft" class="toggle-dark">
                </a>
            </div>
            <!-- End::main-sidebar-header -->
            
            <!-- Start::main-sidebar -->
            <div class="main-sidebar" id="sidebar-scroll">
                <!-- Start::nav -->
                <nav class="main-menu-container nav nav-pills flex-column sub-open">
                    <div class="slide-left" id="slide-left">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path> </svg>
                    </div>
                    <ul class="main-menu">
                        <!-- Start::slide__category -->
                        <li class="slide__category"><span class="category-name">{{trans_dynamic('main_menu')}}</span></li>
                        <!-- End::slide__category -->

                        <!-- Start::slide -->
                        <li class="slide">
                            <a href="{{route('home.superadmin')}}" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class="bx bx-desktop"></i>
                                </span>
                                <span class="side-menu__label">{{trans_dynamic('home')}}</span>
                            </a>
                        </li>
                        <!-- End::slide -->

                        <!-- Start::slide -->
                        <li class="slide has-sub">
                            <a href="javascript:void(0);" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class="bx bxs-home"></i>
                                </span>
                                <span class="side-menu__label">{{trans_dynamic('companies')}}</span>
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child1">
                                <li class="slide side-menu__label1">
                                    <a href="javascript:void(0)">{{trans_dynamic('companies')}}</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('companies')}}" class="side-menu__item">{{trans_dynamic('companies')}}</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('companies.new')}}" class="side-menu__item">{{trans_dynamic('company_add')}}</a>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="slide has-sub">
                            <a href="javascript:void(0);" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class="bx bx-user"></i>
                                </span>
                                <span class="side-menu__label">{{trans_dynamic('users')}}</span>
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child1">
                                <li class="slide side-menu__label1">
                                    <a href="javascript:void(0)">{{trans_dynamic('users')}}</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('users')}}" class="side-menu__item">{{trans_dynamic('users')}}</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('user.create')}}" class="side-menu__item">{{trans_dynamic('user_add')}}</a>
                                </li>
                            </ul>
                        </li>

                        <li class="slide has-sub">
                            <a href="javascript:void(0);" class="side-menu__item">
                                <span class=" side-menu__icon">
                                    <i class="bx bx-flag"></i>
                                </span>
                                <span class="side-menu__label">{{trans_dynamic('languages')}}</span>
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child1">
                                <li class="slide side-menu__label1">
                                    <a href="javascript:void(0)">{{trans_dynamic('languages')}}</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('languages')}}" class="side-menu__item">{{trans_dynamic('languages')}}</a>
                                </li>
                                <li class="slide">
                                    <a href="{{route('languages.new')}}" class="side-menu__item">{{trans_dynamic('language_add')}}</a>
                                </li>
                            </ul>
                        </li>
                        <!-- End::slide -->
                    </ul>
                    <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path> </svg></div>
                </nav>
                <!-- End::nav -->
                
            </div>
            <!-- End::main-sidebar -->
            
        </aside>
        @endif
