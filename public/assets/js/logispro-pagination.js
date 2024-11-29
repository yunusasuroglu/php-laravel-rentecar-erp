$(document).ready(function() {
    var carriers = $(".carrier-card");
    var numEntries = 12;
    var currentPage = 1;
    var maxPageButtons = 10; // Number of page buttons to show at a time
    
    function showPage(page) {
        carriers.hide();
        carriers.slice((page - 1) * numEntries, page * numEntries).show();
    }
    
    function updatePagination() {
        var totalPages = Math.ceil(carriers.length / numEntries);
        var pagination = $("#carrierPagination");
        pagination.empty();
        var startPage = Math.floor((currentPage - 1) / maxPageButtons) * maxPageButtons + 1;
        var endPage = Math.min(startPage + maxPageButtons - 1, totalPages);
        
        if (startPage > 1) {
            pagination.append('<li class="page-item"><a class="page-link" href="#" data-page="' + (startPage - 1) + '">&laquo;</a></li>');
        }
        for (var i = startPage; i <= endPage; i++) {
            pagination.append('<li class="page-item ' + (i === currentPage ? 'active' : '') + '"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>');
        }
        if (endPage < totalPages) {
            pagination.append('<li class="page-item"><a class="page-link" href="#" data-page="' + (endPage + 1) + '">&raquo;</a></li>');
        }
    }
    
    function filterCarriers() {
        var query = $("#carrierSearchInput").val().toLowerCase();
        carriers.each(function() {
            var carrierName = $(this).find(".carrier-name").text().toLowerCase();
            if (carrierName.includes(query)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
        if (query.length > 0) {
            $("#carrierPagination").hide();
        } else {
            $("#carrierPagination").show();
        }
    }
    
    
    $("#carrierEntriesSelect").change(function() {
        numEntries = parseInt($(this).val());
        currentPage = 1;
        updatePagination();
        showPage(currentPage);
    });
    
    $("#carrierSearchInput").on("input", function() {
        filterCarriers();
    });
    
    $(document).on("click", ".page-link", function(e) {
        e.preventDefault();
        currentPage = parseInt($(this).data("page"));
        updatePagination();
        showPage(currentPage);
    });
    
    updatePagination();
    showPage(currentPage);
});

$(document).ready(function() {
    var customers = $(".customer-card");
    var numEntries = 12;
    var currentPage = 1;
    var maxPageButtons = 10; // Number of page buttons to show at a time
    
    function showPage(page) {
        customers.hide();
        customers.slice((page - 1) * numEntries, page * numEntries).show();
    }
    
    function updatePagination() {
        var totalPages = Math.ceil(customers.length / numEntries);
        var pagination = $("#customerPagination");
        pagination.empty();
        var startPage = Math.floor((currentPage - 1) / maxPageButtons) * maxPageButtons + 1;
        var endPage = Math.min(startPage + maxPageButtons - 1, totalPages);
        
        if (startPage > 1) {
            pagination.append('<li class="page-item"><a class="page-link" href="#" data-page="' + (startPage - 1) + '">&laquo;</a></li>');
        }
        for (var i = startPage; i <= endPage; i++) {
            pagination.append('<li class="page-item ' + (i === currentPage ? 'active' : '') + '"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>');
        }
        if (endPage < totalPages) {
            pagination.append('<li class="page-item"><a class="page-link" href="#" data-page="' + (endPage + 1) + '">&raquo;</a></li>');
        }
    }
    
    function filterCustomers() {
        var query = $("#customerSearchInput").val().toLowerCase();
        customers.each(function() {
            var customerName = $(this).find(".customer-name").text().toLowerCase();
            if (customerName.includes(query)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
        if (query.length > 0) {
            $("#customerPagination").hide();
        } else {
            $("#customerPagination").show();
        }
    }
    
    
    $("#customerEntriesSelect").change(function() {
        numEntries = parseInt($(this).val());
        currentPage = 1;
        updatePagination();
        showPage(currentPage);
    });
    
    $("#customerSearchInput").on("input", function() {
        filterCustomers();
    });
    
    $(document).on("click", ".page-link", function(e) {
        e.preventDefault();
        currentPage = parseInt($(this).data("page"));
        updatePagination();
        showPage(currentPage);
    });
    
    updatePagination();
    showPage(currentPage);
});

$(document).ready(function() {
    var employees = $(".employee-card");
    var numEntries = 6;
    var currentPage = 1;
    var maxPageButtons = 10; // Number of page buttons to show at a time
    
    function showPage(page) {
        employees.hide();
        employees.slice((page - 1) * numEntries, page * numEntries).show();
    }
    
    function updatePagination() {
        var totalPages = Math.ceil(employees.length / numEntries);
        var pagination = $("#employeePagination");
        pagination.empty();
        var startPage = Math.floor((currentPage - 1) / maxPageButtons) * maxPageButtons + 1;
        var endPage = Math.min(startPage + maxPageButtons - 1, totalPages);
        
        if (startPage > 1) {
            pagination.append('<li class="page-item"><a class="page-link" href="#" data-page="' + (startPage - 1) + '">&laquo;</a></li>');
        }
        for (var i = startPage; i <= endPage; i++) {
            pagination.append('<li class="page-item ' + (i === currentPage ? 'active' : '') + '"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>');
        }
        if (endPage < totalPages) {
            pagination.append('<li class="page-item"><a class="page-link" href="#" data-page="' + (endPage + 1) + '">&raquo;</a></li>');
        }
    }
    
    function filterEmployees() {
        var query = $("#employeeSearchInput").val().toLowerCase();
        employees.each(function() {
            var employeeName = $(this).find(".employee-name").text().toLowerCase();
            if (employeeName.includes(query)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
        if (query.length > 0) {
            $("#employeePagination").hide();
        } else {
            $("#employeePagination").show();
        }
    }
    
    
    $("#employeeEntriesSelect").change(function() {
        numEntries = parseInt($(this).val());
        currentPage = 1;
        updatePagination();
        showPage(currentPage);
    });
    
    $("#employeeSearchInput").on("input", function() {
        filterEmployees();
    });
    
    $(document).on("click", ".page-link", function(e) {
        e.preventDefault();
        currentPage = parseInt($(this).data("page"));
        updatePagination();
        showPage(currentPage);
    });
    
    updatePagination();
    showPage(currentPage);
});