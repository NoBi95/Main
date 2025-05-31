       function baseUrl() {
    return location.protocol + "//" + location.host;
}

// Reusable table reload function
function reload_table(tableid, url, colDefs, cols) {
    $(tableid).hide();
    table.destroy();
    table = $(tableid).DataTable({
        responsive: true,
    processing: true,
    serverSide: true,
        ajax: baseUrl() + '/' + url,
        columnDefs: colDefs,
        columns: cols
    });
    setTimeout(function() {
        $(tableid).fadeIn('slow');
    }, 300);
}

// Customer table configuration
const customerColDefs = [
        { targets: '_all', visible: true },
];

const customerCols = [
        {
            data: 'customer_id',
            name: 'customer_id',
            title: 'ID'
        },
        {
            data: 'name',
            name: 'name',
            title: 'CUSTOMER NAME'
        },
        {
            data: 'phone',
            name: 'phone',
            title: 'PHONE'
        },
        {
            data: 'email',
            name: 'email',
            title: 'EMAIL'
        },
        {
            data: null,
            title: 'Actions',
            orderable: false,
            searchable: false,
            render: function(data) {
                return `
                <div id="table-action" class="flex gap-2">
                    <a href="javascript:void(0)" 
                        class="table-action editCustomerModal"
                        data-id="${data.customer_id}"
                        data-name="${data.name}"
                        data-phone="${data.phone}"
                        data-email="${data.email}"
                        title="Edit Customer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </a>
                    <a href="javascript:void(0)" 
                        class="table-action deleteCustomer"
                        data-id="${data.customer_id}"
                        title="Delete Customer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                        </a>
                    </div>
                `;
            }
        }
];

// Initialize customer table
let customerTable = new DataTable('#customertable', {
    responsive: true,
    processing: true,
    serverSide: true,
    ajax: baseUrl() + '/customers/list',
    columnDefs: customerColDefs,
    columns: customerCols
});

// Modal & Form Logic
const backdrop = document.getElementById('modal-backdrop');

$('#addCustomerBtn').on('click', function() {
    $('#modalTitle').text('Add Customer');
    $('#customerForm')[0].reset();
    $('#id').val('');
    showModal(document.getElementById('crud-modal'));
});

$('#customertable').on('click', '.editCustomerModal', function () {
    console.log('Customer name:', $(this).data('name'));
    $('#modalTitle').text('Edit Customer');
    $('#name').val($(this).data('name'));
    $('#email').val($(this).data('email'));
    $('#phone').val($(this).data('phone'));
    $('#id').val($(this).data('id'));
    $('#account-name').text($(this).data('name'));
    showModal(document.getElementById('crud-modal'));
});

$('.close-modal').on('click', function () {
    hideModal(document.getElementById('crud-modal'));
});

function showModal(modal) {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    backdrop.classList.remove('hidden');
}

function hideModal(modal) {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    backdrop.classList.add('hidden');
}

$("#customerForm").submit(function (e) {
    e.preventDefault();
    const id = $('#id').val();
    const url = id ? baseUrl() + '/customers/update/' + id : baseUrl() + '/customers/store';
    
    $.ajax({
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: url,
        data: {
            name: $('#name').val(),
            email: $('#email').val(),
            phone: $('#phone').val()
        },
        success: function (response) {
            alert(id ? 'Customer updated successfully' : 'Customer added successfully');
            hideModal(document.getElementById('crud-modal'));
            customerTable.ajax.reload();
        },
        error: function (err) {
            console.log(err);
            alert(id ? 'Failed to update customer' : 'Failed to add customer');
        }
    });
});

// Add delete functionality
$('#customertable').on('click', '.deleteCustomer', function () {
    const id = $(this).data('id');
    if (confirm('Are you sure you want to delete this customer?')) {
        $.ajax({
            type: 'DELETE',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: baseUrl() + '/customers/' + id,
            success: function (response) {
                alert('Customer deleted successfully');
                customerTable.ajax.reload(null, false); // <-- simpler & better
            },
            error: function (err) {
                console.log(err);
                alert('Failed to delete customer');
            }
        });
    }
});


// Staff table configuration
const staffColDefs = [
    { targets: '_all', visible: true },
];

const staffCols = [
    {
        data: 'staff_id',
        name: 'staff_id',
        title: 'ID'
    },
    {
        data: 'name',
        name: 'name',
        title: 'STAFF NAME'
    },
    {
        data: 'role',
        name: 'role',
        title: 'STAFF ROLE'
    },
    {
        data: 'hire_date',
        name: 'hire_date',
        title: 'HIRE DATE'
    },
    {
        data: null,
        title: 'Actions',
        orderable: false,
        searchable: false,
        render: function(data) {
            return `
                <div id="table-action" class="flex gap-2">
                    <a href="javascript:void(0)" 
                        class="table-action editStaffModal"
                        data-id="${data.staff_id}"
                        data-name="${data.name}"
                        data-role="${data.role}"
                        data-hire-date="${data.hire_date}"
                        title="Edit Staff">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                    </a>
                    <a href="javascript:void(0)" 
                        class="table-action deleteStaff"
                        data-id="${data.staff_id}"
                        title="Delete Staff">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </a>
                </div>
            `;
        }
    }
];

// Initialize staff table
let staffTable = new DataTable('#stafftable', {
    responsive: true,
    processing: true,
    serverSide: true,
    ajax: baseUrl() + '/staff/list',
    columnDefs: staffColDefs,
    columns: staffCols
});

// Staff Modal & Form Logic
$('#addStaffBtn').on('click', function() {
    $('#modalTitle').text('Add Staff');
    $('#staffForm')[0].reset();
    $('#id').val('');
    $('#account-name').text('');
    showModal(document.getElementById('crud-modal'));
});

$('#stafftable').on('click', '.editStaffModal', function () {
    $('#modalTitle').text('Edit Staff');
    $('#name').val($(this).data('name'));
    $('#role').val($(this).data('role'));
    $('#hire_date').val($(this).data('hire-date'));
    $('#id').val($(this).data('id'));
    $('#account-name').text($(this).data('name'));
    showModal(document.getElementById('crud-modal'));
});

$('.close-modal').on('click', function () {
    hideModal(document.getElementById('crud-modal'));
});

function showModal(modal) {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    backdrop.classList.remove('hidden');
}

function hideModal(modal) {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    backdrop.classList.add('hidden');
}

$("#staffForm").submit(function (e) {
    e.preventDefault();
    const id = $('#id').val();
    const url = id ? baseUrl() + '/staff/update/' + id : baseUrl() + '/staff/store';
    
    $.ajax({
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: url,
        data: {
            name: $('#name').val(),
            role: $('#role').val(),
            hire_date: $('#hire_date').val()
        },
        success: function (response) {
            alert(id ? 'Staff updated successfully' : 'Staff added successfully');
            hideModal(document.getElementById('crud-modal'));
            staffTable.ajax.reload();
        },
        error: function (err) {
            console.log(err);
            alert(id ? 'Failed to update staff' : 'Failed to add staff');
        }
    });
});

// Staff delete functionality
$('#stafftable').on('click', '.deleteStaff', function () {
    const id = $(this).data('id');
    if (confirm('Are you sure you want to delete this staff member?')) {
        $.ajax({
            type: 'DELETE',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: baseUrl() + '/staff/' + id,
            success: function (response) {
                alert('Staff deleted successfully');
                staffTable.ajax.reload();
            },
            error: function (err) {
                console.log(err);
                alert('Failed to delete staff');
            }
        });
    }
});

// Table table configuration
const tableColDefs = [
    { targets: '_all', visible: true },
];

const tableCols = [
    { data: 'table_id', name: 'table_id', title: 'ID' },
    { data: 'table_number', name: 'table_number', title: 'Table Number' },
    { data: 'capacity', name: 'capacity', title: 'Capacity' },
    { data: 'status', name: 'status', title: 'Status' },
        {
            data: null,
        title: 'Actions',
            orderable: false,
            searchable: false,
        render: function(data) {
                return `
                <div class="flex gap-2">
                    <a href="javascript:void(0)" class="editTableModal" data-id="${data.table_id}" data-table_number="${data.table_number}" data-capacity="${data.capacity}" data-status="${data.status}" title="Edit Table"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg
                        </a>
                    <a href="javascript:void(0)" class="deleteTable" data-id="${data.table_id}" title="Delete Table">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </a>
                    </div>
                `;
            }
        }
];

let tableTable = new DataTable('#tablelist', {
    responsive: true,
    processing: true,
    serverSide: true,
    ajax: baseUrl() + '/tables/list',
    columnDefs: tableColDefs,
    columns: tableCols
});

// Table Modal & Form Logic
$('#addTableBtn').on('click', function() {
    $('#modalTitle').text('Add Table');
    $('#tableForm')[0].reset();
    $('#id').val('');
    $('#account-name').text('');
    showModal(document.getElementById('crud-modal'));
});

$('#tablelist').on('click', '.editTableModal', function () {
    $('#modalTitle').text('Edit Table');
    $('#table_number').val($(this).data('table_number'));
    $('#capacity').val($(this).data('capacity'));
    $('#status').val($(this).data('status'));
    $('#id').val($(this).data('id'));
    $('#account-name').text('Table ' + $(this).data('table_number'));
    showModal(document.getElementById('crud-modal'));
});

$("#tableForm").submit(function (e) {
    e.preventDefault();
    const id = $('#id').val();
    const url = id ? baseUrl() + '/tables/update/' + id : baseUrl() + '/tables/store';

    $.ajax({
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: url,
        data: {
            table_number: $('#table_number').val(),
            capacity: $('#capacity').val(),
            status: $('#status').val()
        },
        success: function (response) {
            alert(id ? 'Table updated successfully' : 'Table added successfully');
            hideModal(document.getElementById('crud-modal'));
            tableTable.ajax.reload();
        },
        error: function (err) {
            console.log(err);
            alert(id ? 'Failed to update table' : 'Failed to add table');
        }
    });
});

$('#tablelist').on('click', '.deleteTable', function () {
    const id = $(this).data('id');
    if (confirm('Are you sure you want to delete this table?')) {
        $.ajax({
            type: 'DELETE',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: baseUrl() + '/tables/' + id,
            success: function (response) {
                alert('Table deleted successfully');
                tableTable.ajax.reload();
            },
            error: function (err) {
                alert('Failed to delete table');
            }
        });
    }
});

// Menu Items table configuration
const menuItemColDefs = [
    { targets: '_all', visible: true },
];

const menuItemCols = [
    { data: 'item_id', name: 'item_id', title: 'ID' },
    { data: 'name', name: 'name', title: 'Name' },
    { data: 'description', name: 'description', title: 'Description' },
    { data: 'category', name: 'category', title: 'Category' },
    { data: 'price', name: 'price', title: 'Price' },
                    {
                        data: null,
                        title: 'Actions',
                        orderable: false,
                        searchable: false,
        render: function(data) {
                            return `
                <div class="flex gap-2">
                    <a href="javascript:void(0)" class="editMenuItemModal" data-id="${data.item_id}" data-name="${data.name}" data-description="${data.description}" data-category="${data.category}" data-price="${data.price}" title="Edit Menu Item">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </a>
                    <a href="javascript:void(0)" class="deleteMenuItem" data-id="${data.item_id}" title="Delete Menu Item">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </a>
                            </div>
                            `;
                    }
                }
];

// Initialize menu items table
let menuItemTable = new DataTable('#menuitemstable', {
    responsive: true,
    processing: true,
    serverSide: true,
    ajax: baseUrl() + '/menuitems/list',
    columnDefs: menuItemColDefs,
    columns: menuItemCols
});

// Menu Items Modal & Form Logic
$('#addMenuItemBtn').on('click', function() {
    $('#modalTitle').text('Add Menu Item');
    $('#menuItemForm')[0].reset();
    $('#id').val('');
    $('#account-name').text('');
    showModal(document.getElementById('crud-modal'));
});

$('#menuitemstable').on('click', '.editMenuItemModal', function () {
    $('#modalTitle').text('Edit Menu Item');
    $('#name').val($(this).data('name'));
    $('#description').val($(this).data('description'));
    $('#category').val($(this).data('category'));
    $('#price').val($(this).data('price'));
    $('#id').val($(this).data('id'));
    $('#account-name').text($(this).data('name'));
    showModal(document.getElementById('crud-modal'));
});

$("#menuItemForm").submit(function (e) {
    e.preventDefault();
    const id = $('#id').val();
    const url = id ? baseUrl() + '/menuitems/update/' + id : baseUrl() + '/menuitems/store';
    
    $.ajax({
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: url,
        data: {
            name: $('#name').val(),
            description: $('#description').val(),
            category: $('#category').val(),
            price: $('#price').val()
        },
        success: function (response) {
            alert(id ? 'Menu item updated successfully' : 'Menu item added successfully');
            hideModal(document.getElementById('crud-modal'));
            menuItemTable.ajax.reload();
        },
        error: function (err) {
            console.log(err);
            alert(id ? 'Failed to update menu item' : 'Failed to add menu item');
        }
    });
});

// Menu Items delete functionality
$('#menuitemstable').on('click', '.deleteMenuItem', function () {
    const id = $(this).data('id');
    if (confirm('Are you sure you want to delete this menu item?')) {
        $.ajax({
            type: 'DELETE',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: baseUrl() + '/menuitems/' + id,
            success: function (response) {
                alert('Menu item deleted successfully');
                menuItemTable.ajax.reload();
            },
            error: function (err) {
                console.log(err);
                alert('Failed to delete menu item');
            }
        });
    }
});
document.addEventListener('DOMContentLoaded', function () {
    const {
        weeklyCustomers,
        monthlyCustomers,
        weeklyData,
        monthlyData,
        weeklyBestSellers,
        monthlyBestSellers
    } = window.dashboardData;

    // Customer Toggle
    const customerCount = document.getElementById('customerCount');
    document.getElementById('custWeeklyBtn').addEventListener('click', () => {
        customerCount.textContent = weeklyCustomers;
    });
    document.getElementById('custMonthlyBtn').addEventListener('click', () => {
        customerCount.textContent = monthlyCustomers;
    });

    // Orders Chart
    const ctx = document.getElementById('ordersChart').getContext('2d');
    const formatChartData = (data) => ({
        labels: Object.keys(data),
        datasets: [{
            label: 'Orders',
            data: Object.values(data),
            backgroundColor: 'rgba(54, 162, 235, 0.4)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    });

    const ordersChart = new Chart(ctx, {
        type: 'bar',
        data: formatChartData(weeklyData),
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    document.getElementById('ordersWeeklyBtn').addEventListener('click', () => {
        ordersChart.data = formatChartData(weeklyData);
        ordersChart.update();
    });

    document.getElementById('ordersMonthlyBtn').addEventListener('click', () => {
        ordersChart.data = formatChartData(monthlyData);
        ordersChart.update();
    });

    // Best Sellers Toggle
    const bestSellerList = document.getElementById('bestSellerList');
    const renderBestSellers = (list) => {
        bestSellerList.innerHTML = '';
        list.forEach(item => {
            const li = document.createElement('li');
            li.innerHTML = `<span class="font-semibold">${item.name}</span> — ${item.total_sold}`;
            bestSellerList.appendChild(li);
        });
    };

    document.getElementById('bestWeeklyBtn').addEventListener('click', () => {
        renderBestSellers(weeklyBestSellers);
    });

    document.getElementById('bestMonthlyBtn').addEventListener('click', () => {
        renderBestSellers(monthlyBestSellers);
    });
});
