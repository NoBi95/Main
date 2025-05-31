function baseUrl() {
    return location.protocol + "//" + location.host;
}

// Customers Table
const customerTable = new DataTable('#customertable', {
    ajax: baseUrl() + '/customers/list',
    processing: true,
    serverSide: true,
    columnDefs: [
        { targets: '_all', visible: true },
    ],
    columns: [
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
                    <div id="table-action">
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
                    </div>
                `;
            }
        }
    ]
});

// Modal & Form Logic
const backdrop = document.getElementById('modal-backdrop');

$('#customertable').on('click', '.editCustomerModal', function () {
    $('#name').val($(this).data('name'));
    $('#email').val($(this).data('email'));
    $('#phone').val($(this).data('phone'));
    $('#id').val($(this).data('id'));

    showModal(document.getElementById('crud-modal'));
});

$('.close-modal').on('click', function () {
    hideModal(document.getElementById('crud-modal'));
});

// Show/hide modal functions
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

// Form submission
$("#updateCustomer").click(function () {
    $("#updateCustomerForm").submit();
});

$("#updateCustomerForm").submit(function (e) {
    e.preventDefault();

    $.ajax({
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: baseUrl() + '/customer/update',
        data: {
            id: $('#id').val(),
            name: $('#name').val(),
            email: $('#email').val(),
            phone: $('#phone').val()
        },
        success: function (response) {
            if (response.status === 'success') {
                alert(response.message);
                hideModal(document.getElementById('crud-modal'));
                customerTable.ajax.reload(); // reload updated table
            }
        },
        error: function (err) {
            console.log(err);
        }
    });
});


// Staff Table
const StaffTable = new DataTable('#stafftable', {
    ajax: baseUrl() + '/staff/list',
    processing: true,
    serverSide: true,
    columnDefs: [
        { targets: [0, 1, 2, 3, 4], visible: true },
        { targets: '_all', visible: false }
    ],
    columns: [
        { data: 'staff_id', name: 'staff_id', title: 'STAFF_ID' },
        { data: 'name', name: 'name', title: 'STAFF NAME' },
        { data: 'role', name: 'role', title: 'STAFF ROLE' },
        { data: 'hire_date', name: 'hire_date', title: 'HIRE DATE' },
        {
            data: null,
            title: 'Actions',
            orderable: false,
            searchable: false
        }
    ]
});

// Tables Table
const tableTable = new DataTable('#tablestable', {
    ajax: baseUrl() + '/tables/list',
    processing: true,
    serverSide: true,
    columnDefs: [
        { targets: [0, 1, 2, 3, 4], visible: true },
        { targets: '_all', visible: false }
    ],
    columns: [
        {
         data: 'table_id',
         name: 'table_id', 
         title: 'TABLE_ID' 
        },
        { 
         data: 'table_number', 
         name: 'table_number', 
         title: 'TABLE_NUMBER' 
        },
        { 
         data: 'capacity', 
         name: 'capacity', 
         title: 'CAPACITY' 
        },
        { 
         data: 'status', 
         name: 'status', 
         title: 'STATUS' },
        {
            data: null,
            title: 'Actions',
            orderable: false,
            searchable: false
        }
    ]
});

// Menu Items Table 
const MenuTable = new DataTable('#menuitemstable', {
    ajax: baseUrl() + '/menuitemstable/list',
    processing: true,
    serverSide: true,
    columnDefs: [
        { targets: [0, 1, 2, 3, 4, 5], visible: true },
        { targets: '_all', visible: false }
    ],
    columns: [
        { data: 'item_id', 
        name: 'item_id', title: 'ID' },
        {
             data: 'name',
             name: 'name',
             title: 'ITEM NAME'
         },
        {
             data: 'description',
             name: 'description',
             title: 'DESCRIPTION' 
        },
        { 
            data: 'category', 
            name: 'category',
            title: 'CATEGORY'
         },
        { 
            data: 'price',
            name: 'price', 
            title: 'PRICE' 
        },
        {
            data: null,
            title: 'Actions',
            orderable: false,
            searchable: false
        }
    ]
});
