@extends('layouts.layout')
@section('title', 'Diller / Ayarlar')
@section('content')
<link rel="stylesheet" href="{{asset('/')}}/assets/libs/gridjs/theme/mermaid.min.css">
<div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between ">
    <h4 class="fw-medium mb-0">{{trans_dynamic('keys')}}</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">{{trans_dynamic('languages')}}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">{{trans_dynamic('keys')}}</li>
    </ol>
</div>
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <form method="POST" action="{{ route('languages.translations.update', $language->code) }}">
                    @csrf
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">
                                {{trans_dynamic('keys')}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <input type="text" id="searchBox" class="form-control" placeholder="Ara..." aria-label="Ara...">
                            </div>
                            <div id="translationsContainer">
                                @foreach ($translations as $translation)
                                <div class="input-group mb-3 translation-item">
                                    <span class="input-group-text" id="basic-addon3">{{ $translation->key }}</span>
                                    <input type="text" name="translations[{{ $translation->id }}]" class="form-control" value="{{ $translation->value }}" aria-describedby="basic-addon3">
                                </div>
                                @endforeach
                            </div>
                            <div class="d-flex justify-content-center">
                                <nav>
                                    <ul id="paginationContainer" class="pagination">
                                        <!-- Sayfa numaraları ve düğmeleri buraya otomatik olarak eklenecek -->
                                    </ul>
                                </nav>
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">{{trans_dynamic('edit')}}</button>
                            </div>
                        </div>
                        <script>

document.addEventListener('DOMContentLoaded', function() {
        const itemsPerPage = 10; // Sayfa başına gösterilecek öğe sayısı
        let currentPage = 1;
        const items = Array.from(document.querySelectorAll('.translation-item'));
        const searchBox = document.getElementById('searchBox');
        const paginationContainer = document.getElementById('paginationContainer');
        
        function renderItems() {
            const searchTerm = searchBox.value.trim().toLowerCase();
            const filteredItems = items.filter(item => {
                const key = item.querySelector('.input-group-text').innerText.trim().toLowerCase();
                const value = item.querySelector('input').value.trim().toLowerCase();
                return key.includes(searchTerm) || value.includes(searchTerm);
            });
            
            const totalPages = Math.ceil(filteredItems.length / itemsPerPage);
            
            // Geçerli sayfayı sınırla
            if (currentPage < 1) {
                currentPage = 1;
            } else if (currentPage > totalPages && totalPages !== 0) {
                currentPage = totalPages;
            }
            
            const start = (currentPage - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            
            items.forEach(item => item.style.display = 'none'); // Tüm öğeleri gizle
            filteredItems.slice(start, end).forEach(item => item.style.display = ''); // Sadece belirtilen aralıktaki öğeleri göster
            
            renderPagination(totalPages);
        }
        
        function renderPagination(totalPages) {
            paginationContainer.innerHTML = ''; // Sayfalama konteynerini temizle
            
            const pageInfoItem = document.createElement('li');
            pageInfoItem.classList.add('page-item', 'disabled');
            const pageInfoLink = document.createElement('span');
            pageInfoLink.classList.add('page-link');
            pageInfoLink.innerText = `${currentPage} / ${totalPages}`;
            pageInfoItem.appendChild(pageInfoLink);
            paginationContainer.appendChild(pageInfoItem);
            
            const prevPageItem = document.createElement('li');
            prevPageItem.classList.add('page-item');
            if (currentPage === 1) prevPageItem.classList.add('disabled');
            const prevPageLink = document.createElement('a');
            prevPageLink.classList.add('page-link');
            prevPageLink.href = '#';
            prevPageLink.innerText = 'Önceki';
            prevPageLink.addEventListener('click', function(event) {
                event.preventDefault();
                if (currentPage > 1) {
                    currentPage--;
                    renderItems();
                }
            });
            prevPageItem.appendChild(prevPageLink);
            paginationContainer.appendChild(prevPageItem);
            
            const nextPageItem = document.createElement('li');
            nextPageItem.classList.add('page-item');
            if (currentPage === totalPages || totalPages === 0) nextPageItem.classList.add('disabled');
            const nextPageLink = document.createElement('a');
            nextPageLink.classList.add('page-link');
            nextPageLink.href = '#';
            nextPageLink.innerText = 'Sonraki';
            nextPageLink.addEventListener('click', function(event) {
                event.preventDefault();
                if (currentPage < totalPages) {
                    currentPage++;
                    renderItems();
                }
            });
            nextPageItem.appendChild(nextPageLink);
            paginationContainer.appendChild(nextPageItem);
        }
        
        searchBox.addEventListener('input', function() {
            currentPage = 1;
            renderItems();
        });
        
        renderItems(); // İlk render işlemi
    });
                            
                            
                        </script>
                    </div>
                </form>
                {{-- <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Kelimeler</div>
                        <div style="margin-left: auto;" class="card-title"> <a href="{{route('languages.new')}}" class="btn btn-primary">Kelime Ekle</a></div>
                    </div>
                    <div class="card-body">
                        
                        <div id="file-export_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                            <div class="dataTables_scroll">
                                <div class="dataTables_scrollHead" style="overflow: hidden; position: relative; border: 0px; width: 100%;">
                                    <div class="dataTables_scrollHeadInner" style="box-sizing: content-box; width: 719px; padding-right: 0px;">
                                        <table class="table table-bordered text-nowrap dataTable no-footer" style="width: 719px; margin-left: 0px;">
                                            <thead>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div class="dataTables_scrollBody " style="position: relative; overflow: auto; width: 100%;">
                                    <table id="file-export" class="table table-bordered text-nowrap dataTable no-footer" style="width: 100%;" aria-describedby="file-export_info">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="sorting sorting_asc" tabindex="0" aria-controls="file-export" rowspan="1" colspan="1" style="width: 94.9375px;" aria-sort="id" aria-label="Id: activate to sort column descending">ID</th>
                                                <th scope="col" class="sorting" tabindex="0" aria-controls="file-export" rowspan="1" colspan="1" style="width: 169.663px;" aria-label="Dil: activate to sort column ascending">Dil</th>
                                                <th scope="col" class="sorting sorting_asc" tabindex="0" aria-controls="file-export" rowspan="1" colspan="1" style="width: 94.9375px;" aria-sort="Dil Kodu" aria-label="Telefon: activate to sort column descending">Anahtar</th>
                                                <th scope="col" class="sorting sorting_asc" tabindex="0" aria-controls="file-export" rowspan="1" colspan="1" style="width: 94.9375px;" aria-sort="Telefon" aria-label="Telefon: activate to sort column descending">Cevap</th>
                                                <th scope="col" class="sorting" tabindex="0" aria-controls="file-export" rowspan="1" colspan="1" style="width: 56.6px;" aria-label="Detay: activate to sort column ascending">Detay</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $counter = 0;
                                            @endphp
                                            
                                            @foreach ($translations as $translation)
                                            <tr class="{{ $counter % 2 == 0 ? 'odd' : 'even' }}">
                                                <td class="sorting_1">{{ $counter }}</td>
                                                <td>{{ $translation->key }}</td>
                                                <td>{{ $translation->value }}</td>
                                                <td class="text-center">
                                                    <form action="{{ route('translations.edit', $translation->id) }}" method="POST">
                                                        <a href="{{ route('translations.destroy', $translation->id) }}" class="btn btn-success">Düzenle</a>
                                                        
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger" type="submit">Sil</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @php
                                            $counter++;
                                            @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="dataTables_paginate paging_simple_numbers" id="file-export_paginate">
                                
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>

@endsection