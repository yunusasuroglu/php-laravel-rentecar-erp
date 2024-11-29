@extends('layouts.layout')
@section('title', 'Vehicle Calendar')
@section('content')
<link rel="stylesheet" href="{{asset('/')}}/assets/libs/gridjs/theme/mermaid.min.css">
<style>
    #responsiveDataTable_wrapper .row{
        margin-bottom: 20px;
    }
</style>
<div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
    <h4 class="fw-medium mb-0">{{trans_dynamic('vehicle')}} {{trans_dynamic('calender')}}</h4>
    <div class="ms-sm-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="" class="text-white-50">{{trans_dynamic('home')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{trans_dynamic('vehicle')}} {{trans_dynamic('calender')}}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="main-content app-content">
    <div class="container-fluid">
        
        
        <!-- Start::row-1 -->
        <div class="row">
            <div class="col-xl-2">
                <div class="card custom-card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <span class="fs-14 text-muted">
                                <i style="color:gray;" class="bx bxs-circle me-1"></i>
                                {{trans_dynamic('gray')}} {{trans_dynamic('draft')}} {{trans_dynamic('contracts')}}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2">
                <div class="card custom-card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <span class="fs-14 text-muted">
                                <i style="color:green;" class="bx bxs-circle me-1"></i>
                                {{trans_dynamic('green')}} {{trans_dynamic('handover')}} {{trans_dynamic('contracts')}}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="card custom-card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <span class="fs-14 text-muted">
                                <i style="color:red;" class="bx bxs-circle me-1"></i>
                                {{trans_dynamic('cancelled_message')}}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2">
                <div class="card custom-card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <span class="fs-14 text-muted">
                                <i style="color:blue;" class="bx bxs-circle me-1"></i>
                                {{trans_dynamic('blue')}} {{trans_dynamic('pickup')}} {{trans_dynamic('contracts')}}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2">
                <div class="card custom-card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <span class="fs-14 text-muted">
                                <i style="color:orange;" class="bx bxs-circle me-1"></i>
                                {{trans_dynamic('handover')}} {{trans_dynamic('and')}} {{trans_dynamic('received')}} {{trans_dynamic('contracts')}}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            
            
            <div class="card custom-card">
                <div class="card-body">
                    <style>
                        #calendar {
                            max-width: 100% !important;
                            margin: 0px auto;
                        }
                        
                        .fc-license-message {
                            display: none;
                        }
                        
                        .fc-h-event {
                            display: -webkit-flex !important;
                        }
                        
                        .fc-direction-ltr .fc-timeline-event:not(.fc-event-start)::before,
                        .fc-direction-rtl .fc-timeline-event:not(.fc-event-end)::after {
                            display: none;
                        }
                        
                        .fc-scroller {
                            overflow-x: scroll;
                            scrollbar-width: thick;
                            /* Firefox için */
                        }
                        
                        /* WebKit tarayıcılar (Chrome, Safari) için kaydırma çubuğunu özelleştirme */
                        .fc-scroller::-webkit-scrollbar {
                            height: 12px;
                            /* Kaydırma çubuğu yüksekliği */
                        }
                        
                        .fc-scroller::-webkit-scrollbar-thumb {
                            background-color: #888;
                            /* Kaydırma çubuğu rengi */
                            border-radius: 10px;
                            /* Kenarları yuvarlama */
                        }
                        
                        .fc-scroller::-webkit-scrollbar-track {
                            background: #f1f1f1;
                            /* Kaydırma çubuğu arka plan rengi */
                        }
                        
                        /* Firefox için kaydırma çubuğunu özelleştirme */
                        .fc-scroller {
                            scrollbar-color: #888 #f1f1f1;
                            /* Kaydırma çubuğu ve arka plan rengi */
                            scrollbar-width: thin;
                            /* İnce kaydırma çubuğu */
                        }
                        .custom-card {
                            position: relative;
                        }
                        
                        .custom-card .customer-info {
                            display: none;
                            position: absolute;
                            top: 100%;
                            left: 0;
                            background: #fff;
                            border: 1px solid #ddd;
                            padding: 10px;
                            z-index: 100;
                            width: 100%;
                        }
                        
                        .custom-card:hover .customer-info {
                            display: block;
                        }
                    </style>
                    <div id='calendar'></div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="d-flex align-items-center mb-4 justify-content-between">
                    <h5 class="fw-semibold">
                        {{trans_dynamic('today')}} {{trans_dynamic('events')}}
                    </h5>
                    <button class="btn btn-primary-light btn-sm btn-wave" style="display:none;">{{trans_dynamic('show_all')}}</button>
                </div>
                @if($contractsData->isEmpty())
                <p>{{trans_dynamic('calender_message')}}</p>
                @else
                @foreach($contractsData as $contract)
                {{-- {{dd($contract);}} --}}
                <div class="card custom-card mb-3" data-bs-toggle="popover" data-bs-trigger="hover" title="{{trans_dynamic('customer')}} {{trans_dynamic('info')}}"  data-bs-content="{{trans_dynamic('name')}}: {{ $contract['customer_name'] }}, {{trans_dynamic('phone')}}: {{ $contract['customer_surname'] }}, {{trans_dynamic('email')}}: {{ $contract['customer_phone'] }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <!-- Tarih ve Durum -->
                            <span class="fs-14 text-muted">
                                <i style="color:{{ $contract['color'] }};" class="bx bxs-circle me-1"></i>
                                <!-- Duruma göre teslim veya bitiş tarihi gösteriliyor -->
                                @if($contract['status'] === 'Delivered')
                                {{ \Carbon\Carbon::parse($contract['start_date'])->format('Y-m-d') }}
                                @elseif($contract['status'] === 'Received')
                                {{ \Carbon\Carbon::parse($contract['end_date'])->format('Y-m-d') }}
                                @else
                                {{ \Carbon\Carbon::parse($contract['start_date'])->format('Y-m-d') }} - {{ \Carbon\Carbon::parse($contract['end_date'])->format('Y-m-d') }}
                                @endif
                            </span>
                            
                            <!-- Daha fazla seçenek (Detaylar) -->
                            <div class="dropdown ms-auto">
                                <a href="javascript:void(0);" class="p-2 fs-16 text-muted" data-bs-toggle="dropdown">
                                    <i class="fe fe-more-horizontal"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="border-bottom">
                                        <a class="dropdown-item" href="{{ url('/contracts/detail/' . $contract['contract_id']) }}">{{trans_dynamic('detail')}}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Durum ve Araç Bilgileri -->
                        <h6 class="mb-1 mt-2">{{ $contract['status'] }}</h6>
                        <p class="text-muted mb-0">{{ $contract['car_brand'] }} {{ $contract['car_model'] }}, {{ $contract['car_plate_number'] }}</p>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
            <div class="col-xl-6">
                <div class="d-flex align-items-center mb-4 justify-content-between">
                    <h5 class="fw-semibold">
                        {{trans_dynamic('starting_and_ending')}}
                    </h5>
                    <button class="btn btn-primary-light btn-sm btn-wave" style="display:none;">{{trans_dynamic('show_all')}}</button>
                </div>
                @if($contracts2Data->isEmpty())
                <p>{{trans_dynamic('calender_message')}}</p>
                @else
                @foreach($contracts2Data as $contract)
                {{-- {{dd($contract);}} --}}
                <div class="card custom-card mb-3" data-bs-toggle="popover" data-bs-trigger="hover" title="{{trans_dynamic('customer')}} {{trans_dynamic('info')}}" data-bs-content="{{trans_dynamic('name')}}: {{ $contract['customer_name'] }},  {{trans_dynamic('phone')}}: {{ $contract['customer_surname'] }}, {{trans_dynamic('email')}}: {{ $contract['customer_phone'] }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <span class="fs-14 text-muted">
                                <i style="color:{{ $contract['color'] }};" class="bx bxs-circle me-1"></i>
                                {{ \Carbon\Carbon::parse($contract['start_date'])->format('Y-m-d') }} - {{ \Carbon\Carbon::parse($contract['end_date'])->format('Y-m-d') }}
                            </span>
                            <div class="dropdown ms-auto">
                                <a href="javascript:void(0);" class="p-2 fs-16 text-muted" data-bs-toggle="dropdown">
                                    <i class="fe fe-more-horizontal"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="border-bottom">
                                        <a class="dropdown-item" href="{{ url('/contracts/detail/' . $contract['contract_id']) }}">{{trans_dynamic('detail')}}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <h6 class="mb-1 mt-2">{{ $contract['status'] }}</h6>
                        <p class="text-muted mb-0">{{ $contract['car_brand'] }} {{ $contract['car_model'] }}, {{ $contract['car_plate_number'] }}</p>
                    </div>
                </div>
                @endforeach
                @endif
                <script>
                    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
                    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                        return new bootstrap.Popover(popoverTriggerEl);
                    });
                </script>
            </div>
        </div>
    </div>
    
    
</div>
<!--End::row-1 -->

</div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    const baseURL = window.location.origin;

    // AJAX ile sunucudan verileri alalım
    $.ajax({
        url: baseURL + '/calendar/events',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            const groups = response.resources.map(resource => resource.group);
            const uniqueGroups = [...new Set(groups)]; // Tekrarsız grup listesi
            initializeCalendar(response.resources, response.events);
            // Takvim başlatıldıktan sonra filtreleri ekle
            addFilterToSidebar(uniqueGroups);
        },
        error: function () {
            console.error("{{trans_dynamic('data_could_not_be_retrieved')}}");
        }
    });

    // Takvimi başlatan fonksiyon
    function initializeCalendar(resources, events) {
        var calendar = new FullCalendar.Calendar(calendarEl, {
            timeZone: 'UTC',
            locale: "de",
            headerToolbar: {
                left: 'today prev,next',
                center: 'title',
                right: 'resourceTimelineDay,resourceTimelineWeek,resourceTimeline31Days'
            },
            initialView: 'resourceTimelineDay',
            scrollTime: '00:00',
            contentHeight: "auto",
            stickyFooterScrollbar: false,
            editable: false,
            resourceAreaHeaderContent: "{{trans_dynamic('cars')}}",
            resources: resources,  // Sunucudan gelen kaynaklar (araçlar)
            events: events,        // Sunucudan gelen etkinlikler (kiralama verileri)
            eventDidMount: function(info) {
                const customer = info.event.extendedProps.customer;
                const tooltipContent = `
                {{trans_dynamic('name')}}: ${customer.name}<br>
                {{trans_dynamic('phone')}}: ${customer.phone}<br>
                {{trans_dynamic('email')}}: ${customer.email}<br>
                {{trans_dynamic('age')}}: ${customer.age}
            `;
                $(info.el).tooltip({
                    title: tooltipContent,
                    placement: 'top',
                    html: true,
                    trigger: 'hover',
                    container: 'body'
                });
            }
        });
        calendar.render();
    }

    // Mevcut takvim sidebar'ına dinamik filtre alanı ekleme fonksiyonu
    function addFilterToSidebar(groups) {
        const calendarSidebar = document.querySelector('.fc-datagrid-cell-frame'); // Takvim sidebar'ı

        // Filtreleme elemanlarını oluşturma
        const filterContainer = document.createElement('div');
        filterContainer.classList.add('group-filter-container');
        filterContainer.style.margin = '10px';

        const filterSelect = document.createElement('select');
        filterSelect.classList.add('form-control');
        filterSelect.style.width = '100%';

        // Varsayılan 'Tüm Gruplar' seçeneği
        const defaultOption = document.createElement('option');
        defaultOption.value = 'all';
        defaultOption.innerText = "{{trans_dynamic('all_group')}}";
        filterSelect.appendChild(defaultOption);

        // Grupları filtre dropdown'ına ekleme
        groups.forEach(group => {
            const option = document.createElement('option');
            option.value = group;
            option.innerText = group;
            filterSelect.appendChild(option);
        });

        // Filtreleme olayını tanımlama
        filterSelect.addEventListener('change', function () {
            const selectedGroup = filterSelect.value;
            filterResourcesByGroup(selectedGroup);
        });

        // Filtre elemanlarını ekleme
        filterContainer.appendChild(filterSelect);
        calendarSidebar.appendChild(filterContainer);
    }

    // Filtreye göre takvimdeki kaynakları filtreleme fonksiyonu
    function filterResourcesByGroup(group) {
        const calendar = FullCalendar.Calendar.getInstance(calendarEl);
        const originalResources = calendar.getResources();

        // Tüm kaynakları kaldır
        originalResources.forEach(resource => {
            resource.remove();
        });

        // Seçilen gruba göre kaynakları filtrele
        if (group === 'all') {
            calendar.addResource(resources); // Tüm kaynakları ekle
        } else {
            const filteredResources = resources.filter(resource => resource.extendedProps.group === group);
            filteredResources.forEach(resource => {
                calendar.addResource(resource);
            });
        }
    }
});
    
    calendar.render();
    
</script>
@endsection
