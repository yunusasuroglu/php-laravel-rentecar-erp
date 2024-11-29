document.addEventListener('DOMContentLoaded', function () {
    const brandSelect = document.getElementById('brand');
    const modelSelect = document.getElementById('model');
    
    fetch('/assets/js/cars/modelle.json')
    .then(response => response.json())
    .then(data => {
        data.forEach(brand => {
            const option = document.createElement('option');
            option.value = brand.label;
            option.textContent = brand.label;
            brandSelect.appendChild(option);
        });
        
        brandSelect.addEventListener('change', function () {
            const selectedBrandLabel = this.value;
            const selectedBrand = data.find(brand => brand.label === selectedBrandLabel);
            
            modelSelect.innerHTML = '';
            
            if (selectedBrand && selectedBrand.models) {
                const modelsData = JSON.parse(selectedBrand.models);
                
                modelsData.data.forEach(modelGroup => {
                    if (modelGroup.optgroupLabel) {
                        const optgroup = document.createElement('optgroup');
                        optgroup.label = modelGroup.optgroupLabel;
                        
                        modelGroup.items.forEach(model => {
                            const option = document.createElement('option');
                            option.value = model.label;
                            option.textContent = model.label;
                            optgroup.appendChild(option);
                        });
                        
                        modelSelect.appendChild(optgroup);
                    } else {
                        const option = document.createElement('option');
                        option.value = modelGroup.label;
                        option.textContent = modelGroup.label;
                        modelSelect.appendChild(option);
                    }
                });
            }
        });
        
        brandSelect.dispatchEvent(new Event('change'));
    })
    .catch(error => console.error('Error loading JSON data:', error));
});
document.addEventListener('DOMContentLoaded', function () {
    const brandSelect = document.getElementById('edit_brand');
    const modelSelect = document.getElementById('edit_model');
    
    // PHP'den seçili marka ve modeli al
    const selectedBrand = "{{ $selectedBrand }}";
    const selectedModel = "{{ $selectedModel }}";
    
    // modelle.json'dan veriyi çek
    fetch('/assets/js/cars/modelle.json')
    .then(response => response.json())
    .then(data => {
        data.forEach(brand => {
            const option = document.createElement('option');
            option.value = brand.label;
            option.textContent = brand.label;
            
            // Seçili markayı ayarla
            if (brand.label === selectedBrand) {
                option.selected = true;
            }
            
            brandSelect.appendChild(option);
        });
        
        // Markaya göre modelleri getir
        brandSelect.addEventListener('change', function () {
            const selectedBrandLabel = this.value;
            const selectedBrand = data.find(brand => brand.label === selectedBrandLabel);
            modelSelect.innerHTML = '';
            
            if (selectedBrand && selectedBrand.models) {
                const modelsData = JSON.parse(selectedBrand.models);
                
                modelsData.data.forEach(modelGroup => {
                    if (modelGroup.optgroupLabel) {
                        const optgroup = document.createElement('optgroup');
                        optgroup.label = modelGroup.optgroupLabel;
                        
                        modelGroup.items.forEach(model => {
                            const option = document.createElement('option');
                            option.value = model.label;
                            option.textContent = model.label;
                            
                            // Seçili modeli ayarla
                            if (model.label === selectedModel) {
                                option.selected = true;
                            }
                            
                            optgroup.appendChild(option);
                        });
                        
                        modelSelect.appendChild(optgroup);
                    } else {
                        const option = document.createElement('option');
                        option.value = modelGroup.label;
                        option.textContent = modelGroup.label;
                        
                        // Seçili modeli ayarla
                        if (modelGroup.label === selectedModel) {
                            option.selected = true;
                        }
                        
                        modelSelect.appendChild(option);
                    }
                });
            }
        });
        
        // Sayfa yüklendiğinde markaya göre modelleri getir
        brandSelect.dispatchEvent(new Event('change'));
    })
    .catch(error => console.error('Error loading JSON data:', error));
});
$(document).ready(function () {
    $('#customRange3').on('input change', function () {
        var value = $(this).val();
        $('#fuellevel').text(value + '%');
    });
    
    var initialValue = $('#customRange3').val();
    $('#fuellevel').text(initialValue + '%');
});

$(document).ready(function () {
    $('#customRange4').on('input change', function () {
        var value = $(this).val();
        $('#fuellevel').text(value + '%');
    });
    
    var initialValue = $('#customRange4').val();
    $('#fuellevel1').text(initialValue + '%');
});
$(document).ready(function () {
    $('#customRange5').on('input change', function () {
        var value = $(this).val();
        $('#fuellevel').text(value + '%');
    });
    
    var initialValue = $('#customRange5').val();
    $('#fuellevel2').text(initialValue + '%');
});

