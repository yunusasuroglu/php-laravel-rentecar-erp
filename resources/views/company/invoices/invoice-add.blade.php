@extends('layouts.layout')
@section('title', 'Invoice Add')
@section('content')
<link rel="stylesheet" href="{{asset('/')}}/assets/libs/gridjs/theme/mermaid.min.css">
<style>
    #responsiveDataTable_wrapper .row{
        margin-bottom: 20px;
    }
</style>
<div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
    <h4 class="fw-medium mb-0">{{trans_dynamic('invoice_add')}}</h4>
    <div class="ms-sm-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{route('invoices')}}" class="text-white-50">{{trans_dynamic('invoices')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{trans_dynamic('invoice_add')}}</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header Close -->

<div class="main-content app-content">
    <div class="container-fluid">
        
        @php
        // Adres verisi JSON string mi kontrol ediyoruz, değilse olduğu gibi bırakıyoruz
        $address = is_string($customer['address']) ? json_decode($customer['address'], true) : $customer['address'];
        @endphp
        <!-- Start::row-1 -->
        <div class="row">
            <div class="col-xl-9">
                <div class="card custom-card">
                    <div class="card-header d-md-flex d-block">
                    </div>
                    <form action="{{route('invoices.add')}}" method="POST">
                        @csrf
                        <input type="hidden" name="contract_id" value="{{$contract->id}}">
                        <div class="card-body">
                            <div class="row gy-3">
                                <div class="col-xl-12">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6  mt-3">
                                            <p class="dw-semibold mb-2">
                                                {{trans_dynamic('billing_address')}}:
                                            </p>
                                            <div class="row gy-2">
                                                <div class="col-xl-12">
                                                    <input type="text" name="name" value="{{$customer['name'] ?? ''}} {{$customer['surname'] ?? ''}}" class="form-control" id="customer-Name" placeholder="{{trans_dynamic('customer')}} {{trans_dynamic('name')}}">
                                                    <input type="hidden" value="{{$customerId}} ">
                                                </div>
                                                <div class="col-xl-12">
                                                    <input type="text" name="address" class="form-control" id="customer-address" placeholder="{{trans_dynamic('address')}}" value="{{$address['zip_code'] ?? ''}} {{$address['city'] ?? ''}}">
                                                </div>
                                                <div class="col-xl-12">
                                                    <input type="text" name="zip_code" class="form-control" id="zip-code" placeholder="{{trans_dynamic('zip_code')}}" value="{{$address['city'] ?? ''}}">
                                                </div>
                                                <div class="col-xl-12">
                                                    <input type="text" name="city" class="form-control" id="city" placeholder="{{trans_dynamic('city')}}" value="{{$address['zip_code'] ?? ''}}">
                                                </div>
                                                <div class="col-xl-12">
                                                    <input type="text" name="email" class="form-control" id="customer-mail" placeholder="{{trans_dynamic('customer')}} {{trans_dynamic('email')}}" value="{{$customer['email'] ?? ''}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <label for="invoice-date-issued" class="form-label">{{trans_dynamic('invoice')}} {{trans_dynamic('date')}}</label>
                                    <input type="text" name="invoice_date" value="" class="form-control" id="invoice-date-issued">
                                </div>
                                <!--<div class="col-xl-3">
                                    <label for="invoice-date-due" class="form-label">Due Date</label>
                                    <input type="text" class="form-control" id="invoice-date-due" placeholder="Choose date">
                                </div>
                                <div class="col-xl-3"> 
                                    <label for="invoice-due-amount" class="form-label">Due Amount</label>
                                    <input type="text" class="form-control" id="invoice-due-amount" placeholder="Enter Amount" value="$12,983.78">
                                </div>-->
                                <div class="col-xl-12">
                                    <div class="table-responsive">
                                        <table class="table nowrap text-nowrap border mt-3">
                                            <thead>
                                                <tr>
                                                    <th colspan="2" scope="col">{{trans_dynamic('product')}}</th>
                                                    <th colspan="2" scope="col">{{trans_dynamic('description')}}</th>
                                                    <th colspan="2" scope="col">{{trans_dynamic('price')}}</th>
                                                    <th colspan="2" scope="col">{{trans_dynamic('aktion')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody  id="invoice_items">
                                                <tr id="invoice_item">
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="items[0][name]" placeholder="Enter item Name" value="{{$car['car']['brand'] ?? ''}} {{$car['car']['model'] ?? ''}} {{$car['number_plate'] ?? ''}}">
                                                        <input type="hidden" name="items[0][number_plate]"value="{{$car['number_plate'] ?? ''}}">
                                                    </td>
                                                    <td colspan="2">
                                                        <textarea rows="2" class="form-control mt-1" name="items[0][description]" placeholder="Enter Description">{{$contract['start_date']}} Uhr bis {{$contract['end_date']}} Uhr</textarea>
                                                    </td>
                                                    <td colspan="2">
                                                        <input id="total_amount" class="form-control total-amount invoice-input" name="items[0][total_amount]" placeholder="" type="text" value="{{$contract->total_amount ?? '0' - $contract->tax ?? '0'}}">
                                                    </td>
                                                    <td colspan="2">
                                                        <button disabled class="btn btn-sm btn-icon btn-danger-light"><i class="ri-delete-bin-5-line"></i></button>
                                                    </td>
                                                </tr>
                                                @if($contract->extra_km != 0)
                                                <tr id="invoice_item">
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="items[1][name]" placeholder="Enter item Name" value="Fahrzeugmiete: ">
                                                    </td>
                                                    <td colspan="2">
                                                        <textarea rows="2" class="form-control mt-1" name="items[1][description]" placeholder="{{trans_dynamic('description')}}">{{trans_dynamic('extra')}} KM {{$contract->extra_km}}</textarea>
                                                    </td>
                                                    <td colspan="2">
                                                        <input id="total_amount" class="form-control total-amount invoice-input" name="items[1][total_amount]" placeholder="" type="text" value="{{$contract->extra_km_price}}">
                                                    </td>
                                                    <td colspan="2">
                                                        <button disabled class="btn btn-sm btn-icon btn-danger-light"><i class="ri-delete-bin-5-line"></i></button>
                                                    </td>
                                                </tr>
                                                @endif
                                            </tbody>
                                            <tbody>
                                                <tr>
                                                    <td colspan="4" class="border-bottom-0"><a id="add_item" class="btn btn-light" href="javascript:void(0);">
                                                        <i class="bi bi-plus-lg"></i> {{trans_dynamic('add_line')}}</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4"></td>
                                                    <td colspan="2">
                                                        <table class="table table-sm text-nowrap mb-0 table-borderless">
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row">
                                                                        <div class="fw-semibold">{{trans_dynamic('subtotal')}}:</div>
                                                                        <input id="subtotalHidden" type="hidden" name="subtotal" value="">
                                                                    </th>
                                                                    <td style="text-align:right;">
                                                                        <span id="subtotal"></span> €
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">
                                                                        <div class="fw-semibold">{{trans_dynamic('tax')}} <span class="text-danger">(19%)</span>:</div>
                                                                        <input id="taxHidden" type="hidden" name="tax" value="">
                                                                    </th>
                                                                    <td style="text-align:right;">
                                                                        <span id="tax"></span> €
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">
                                                                        <div class="fw-semibold"> {{trans_dynamic('discount')}}
                                                                            <span class="text-success">(in €)</span>:
                                                                        </div>
                                                                    </th>
                                                                    <td style="text-align:right;">
                                                                        <input id="discount" type="number" name="discount" class="form-control invoice-amount-input" style="text-align:right;" placeholder="{{trans_dynamic('amount')}}" value="0">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">
                                                                        <div class="fs-14 fw-semibold">{{trans_dynamic('total')}}:</div>
                                                                        <input id="totalpriceHidden" type="hidden" name="totalprice" value="">
                                                                    </th>
                                                                    <td style="text-align:right;">
                                                                        <span id="totalprice"></span> €
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                            <script>
                                                                document.addEventListener('DOMContentLoaded', function () {
                                                                    const addLineButton = document.getElementById('add_item');
                                                                    let itemIndex = 1; // Ürünlerin indeksini takip etmek için
                                                                    
                                                                    addLineButton.addEventListener('click', function () {
                                                                        const newRow = `
                                                                            <tr id="invoice_item">
                                                                                <td colspan="2">
                                                                                    <input type="text" class="form-control" name="items[${itemIndex}][name]" placeholder="{{trans_dynamic('enter')}} {{trans_dynamic('item')}} {{trans_dynamic('name')}}">
                                                                                </td>
                                                                                <td colspan="2">
                                                                                    <textarea rows="2" class="form-control mt-1" name="items[${itemIndex}][description]" placeholder="{{trans_dynamic('enter')}} {{trans_dynamic('description')}}"></textarea>
                                                                                </td>
                                                                                <td colspan="2">
                                                                                    <input class="form-control total-amount" name="items[${itemIndex}][total_amount]" placeholder="" type="number">
                                                                                </td>
                                                                                <td colspan="2">
                                                                                    <button class="btn btn-sm btn-icon btn-danger-light delete-invoice-item"><i class="ri-delete-bin-5-line"></i></button>
                                                                                </td>
                                                                            </tr>
                                                                        `;
                                                                        
                                                                        const tableBody = document.querySelector('#invoice_items');
                                                                        tableBody.insertAdjacentHTML('beforeend', newRow);
                                                                        
                                                                        itemIndex++; // İndeksi artır
                                                                        
                                                                        addDeleteFunctionality();
                                                                        addInputEventListeners(); // Yeni eklenen satırlar için olay dinleyicilerini ekle
                                                                    });
                                                                    
                                                                    function addDeleteFunctionality() {
                                                                        document.querySelectorAll('.delete-invoice-item').forEach(button => {
                                                                            button.addEventListener('click', function () {
                                                                                this.closest('tr').remove();
                                                                                updateSummary(); // Satır silindikten sonra toplamı güncelle
                                                                            });
                                                                        });
                                                                    }
                                                                    
                                                                    function addInputEventListeners() {
                                                                        document.querySelectorAll('.total-amount').forEach(input => {
                                                                            input.addEventListener('input', updateSummary);
                                                                        });
                                                                        const discountInput = document.getElementById('discount');
                                                                        if (discountInput) {
                                                                            discountInput.addEventListener('input', updateSummary);
                                                                        }
                                                                    }
                                                                    
                                                                    function updateSummary() {
                                                                        // Daha basit bir seçici kullanarak input elemanlarını seçin
                                                                        const totalAmountInputs = document.querySelectorAll('input.total-amount');
                                                                        
                                                                        let subtotal = 0;
                                                                        
                                                                        totalAmountInputs.forEach(input => {
                                                                            const value = input.value.trim(); // Boşlukları temizle
                                                                            const amount = parseFloat(value);
                                                                            subtotal += isNaN(amount) ? 0 : amount; // NaN kontrolü yap
                                                                        });
                                                                        
                                                                        const discountInput = document.getElementById('discount');
                                                                        const discount = discountInput ? Math.abs(parseFloat(discountInput.value) || 0) : 0; // Negatif değerleri pozitif hale getir
                                                                        
                                                                        const tax = subtotal - (subtotal / 1.19); // KDV'yi hesapla
                                                                        const total = subtotal - discount; // Toplam tutarı hesapla (KDV eklenmiş hali)
                                                                        
                                                                        
                                                                        // Güncelle
                                                                        const subtotalInput = document.getElementById('subtotalHidden');
                                                                        const taxInput = document.getElementById('taxHidden');
                                                                        const totalInput = document.getElementById('totalpriceHidden');
                                                                        const subtotalAmount = document.getElementById('subtotal');
                                                                        const taxAmount = document.getElementById('tax');
                                                                        const totalAmount = document.getElementById('totalprice');
                                                                        
                                                                        if (subtotalInput) {
                                                                            subtotalInput.value = subtotal.toFixed(2);
                                                                        }
                                                                        if (subtotalAmount) {
                                                                            subtotalAmount.textContent = `${subtotal.toFixed(2)}`;
                                                                        }
                                                                        if (taxInput) {
                                                                            taxInput.value = tax.toFixed(2);
                                                                        }
                                                                        if (taxAmount) {
                                                                            taxAmount.textContent = `${tax.toFixed(2)}`;
                                                                        }
                                                                        if (totalInput) {
                                                                            totalInput.value = total.toFixed(2);
                                                                        }
                                                                        if (totalAmount) {
                                                                            totalAmount.textContent = `${total.toFixed(2)}`;
                                                                        }
                                                                    }
                                                                    
                                                                    addInputEventListeners(); // Sayfa yüklendiğinde mevcut girişler için olay dinleyicilerini ekleyin
                                                                    updateSummary(); // Sayfa yüklendiğinde toplama değerlerini güncelle
                                                                    
                                                                    // Tarih ayarını yapalım
                                                                    const today = new Date();
                                                                    const year = today.getFullYear();
                                                                    const month = String(today.getMonth() + 1).padStart(2, '0');
                                                                    const day = String(today.getDate()).padStart(2, '0');
                                                                    const formattedDate = `${year}-${month}-${day}`;
                                                                    
                                                                    document.getElementById('invoice-date-issued').value = formattedDate;
                                                                });
                                                            </script>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div>
                                        <label for="invoice-note" class="form-label">{{trans_dynamic('note')}}:</label>
                                        <textarea name="note" class="form-control" id="invoice-note" rows="3">{{trans_dynamic('note_text')}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button class="btn btn-primary d-inline-flex ">{{trans_dynamic('save_and_send_invoice')}} <i class="ri-send-plane-2-line ms-1 align-middle"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            {{trans_dynamic('pickup')}} {{trans_dynamic('info')}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            @php
                            // Contract ve car damages verilerini JSON'dan çözüyoruz
                            $contractDamages = isset($contract->damages) ? json_decode($contract->damages, true) : [];
                            $carDamages = isset($contract->car['damages']) ? json_decode($contract->car['damages'], true) : [];
                            
                            // Eğer JSON dizileri boşsa, doğru bir karşılaştırma yapmak mümkün olmayacaktır
                            if (empty($contractDamages) && empty($carDamages)) {
                                $allSame = true;
                            } else {
                                // Hasar açıklamalarını normalleştirme
                                $contractDescriptions = array_map(function($damage) {
                                    return trim(strtolower($damage['description']));
                                }, $contractDamages);
                                
                                $carDescriptions = array_map(function($damage) {
                                    return trim(strtolower($damage['description']));
                                }, $carDamages);
                                
                                // Yeni ve kaldırılmış hasar açıklamalarını bulma
                                $newDescriptions = array_diff($contractDescriptions, $carDescriptions);
                                $removedDescriptions = array_diff($carDescriptions, $contractDescriptions);
                                
                                // Tüm hasarların aynı olup olmadığını kontrol etme
                                $allSame = empty($newDescriptions) && empty($removedDescriptions);
                            }
                            @endphp
                            
                            <div class="col-xl-12">
                                <label for="invoice-date-issued" class="form-label">{{trans_dynamic('damages')}}</label>
                                
                                @if($allSame)
                                <p class="text-success">{{trans_dynamic('no_new_damages')}}</p>
                                @else
                                @if(!empty($newDescriptions))
                                <p class="text-danger">{{trans_dynamic('new_damages_found')}}:</p>
                                @foreach($newDescriptions as $description)
                                <p class="text-danger">{{ $description }}</p>
                                @endforeach
                                @endif
                                
                                @if(!empty($removedDescriptions))
                                <p class="text-danger">{{trans_dynamic('removed_damages')}}:</p>
                                @foreach($removedDescriptions as $description)
                                <p class="text-danger">{{ $description }}</p>
                                @endforeach
                                @endif
                                @endif
                            </div>
                            
                            @if ($contract->extra_km == !null)
                            <div class="col-xl-12">
                                <label for="invoice-date-issued" class="form-label">{{trans_dynamic('exceeded')}} {{trans_dynamic('kilometer')}}</label>
                                <p class="text-danger">{{$contract->extra_km}} Km {{trans_dynamic('extra')}} {{trans_dynamic('to_pay')}}</p>
                            </div>
                            @else
                            <div class="col-xl-12">
                                <label for="invoice-date-issued" class="form-label">{{trans_dynamic('exceeded')}} {{trans_dynamic('kilometer')}}</label>
                                <div class="alert alert-success" role="alert">
                                    {{trans_dynamic('no')}} {{trans_dynamic('extra')}} {{trans_dynamic('costs')}}
                                </div>
                            </div>
                            @endif
                            @if ($car['fuel_status'] == $contract->fuel_status)
                            <div class="col-xl-12">
                                <label for="invoice-date-issued" class="form-label">{{trans_dynamic('fuel')}}</label>
                                <div class="alert alert-success" role="alert">
                                    {{trans_dynamic('no')}} {{trans_dynamic('extra')}} {{trans_dynamic('costs')}}
                                </div>
                            </div>
                            @else
                            <div class="col-xl-12">
                                <label for="invoice-date-issued" class="form-label">{{trans_dynamic('exceeded')}} {{trans_dynamic('fuel')}}</label>
                                <p class="text-danger">{{trans_dynamic('handover')}} = %{{$car['fuel_status']}} | {{trans_dynamic('pickup')}} = %{{$contract->fuel_status}}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End::row-1 -->
        
    </div>
</div>



<script src="{{asset('/')}}/assets/libs/@popperjs/core/umd/popper.min.js"></script>
<script src="{{asset('/')}}assets/js/date&amp;time_pickers.js"></script>
@endsection