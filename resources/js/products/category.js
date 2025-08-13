import $ from 'jquery';
window.$ = window.jQuery = $;

const $overlay = $('#overlay');
const $form = $('#categoryForm');
const $formTitle = $('#form-title');

// FORM ANIMATION CUSTOMIZATION
function formAnimation(classA, classB, animationA, animationB) {
    $overlay.removeClass(classA).addClass(classB);
            
    $form.addClass(animationA);

    $form[0].offsetWidth;
    $form.removeClass(animationB);
}

// FORM ANIMATION OUT
function formAnimationOut() {
    $form.removeClass('animate-slide-in').addClass('animate-slide-out');

    // WAIT FOR THE ANIMATION TO FINISH
    setTimeout(() => {
        $overlay.removeClass('flex').addClass('hidden');
        $form.removeClass('animate-slide-out');
    }, 400); // ANIMATION DURATION
}


// // CATEGORIES DISPLAY FUNCTION
// function loadCategories() {
//     $.ajax({
//         type: 'GET',
//         url: `${window.location.origin}/category-list`,
//         success: function(response) {
//             let tbody = $('#category-table tbody');
//             tbody.empty(); // CLEAR PREVIOUS DATA

//             if (response.categories.length === 0) {
//                 let row = `
//                     <tr>
//                         <td colspan="6">
//                             No categories found.
//                         </td>
//                     <tr>
//                 `;

//                 tbody.append(row);
//                 return;
//             }

//             response.categories.forEach(function(category, index) {
//                 let row = `
//                     <tr>
//                         <td>${index + 1}</td>
//                         <td>${category.name}</td>
//                         <td>${category.slug}</td>
//                         <td>${category.created_date}</td>
//                         <td>${category.status.charAt(0).toUpperCase() + category.status.slice(1)}</td>
//                         <td>
//                             <div class="button-action-container">
//                                 <button type="button" class="edit-btn" data-id="${category.encrypted_id}">
//                                     <i class="fas fa-edit"></i>
//                                 </button>
//                                 <button type="button" class="delete-btn" data-id="${category.encrypted_id}">
//                                     <i class="fas fa-trash"></i>
//                                 </button>
//                                 <button type="button" class="status-btn" data-id="${category.encrypted_id}">${category.status === 'active' ? 'Deactivate' : 'Activate'}</button>
//                             </div>
//                         </td>
//                     <tr>
//                 `;

//                 tbody.append(row);
//             });
//         }
//     });
// }

// loadCategories();

let perPage = $('#perPage').val();
let search = '';
let status = '';

$('#perPage').on('change', function() {
    perPage = $(this).val();
    loadCategories(1); // reload from first page when per-page changes
});

// SEARCH STATUS
$('#searchInput').on('keyup', function() {
    search = $(this).val();
    loadCategories(1);
});

// STATUS FILTER
$('#statusDropDownMenu button').on('click', function() {
    let selected = $(this).text().toLowerCase();

    // $('#statusDropdownBtn').text(selected);

    if (selected === 'all') {
        status = ''; // walang status filter
    } else {
        status = selected; // active or inactive
    }

    loadCategories(1); // reload from first page
});




function loadCategories(page = 1) {
    $.ajax({
        type: 'GET',
        url: `${window.location.origin}/category-list?page=${page}&per_page=${perPage}`,
        data: {
            page: page,
            per_page: perPage,
            search: search,
            status: status,
        },
        success: function(response) {
            let tbody = $('#category-table tbody');
            tbody.empty();

            if (response.data.length === 0) {
                tbody.append(`
                    <tr>
                        <td colspan="6">No categories found.</td>
                    </tr>
                `);
                $('#pagination').empty();
                return;
            }

            response.data.forEach(function(category, index) {
                let row = `
                    <tr>
                        <td>${(response.from + index)}</td>
                        <td>${category.name}</td>
                        <td>${category.slug}</td>
                        <td>${category.created_date}</td>
                        <td>${category.status.charAt(0).toUpperCase() + category.status.slice(1)}</td>
                        <td>
                            <div class="button-action-container">
                                <button type="button" class="edit-btn" data-id="${category.encrypted_id}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="delete-btn" data-id="${category.encrypted_id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <button type="button" class="status-btn" data-id="${category.encrypted_id}">
                                    ${category.status === 'active' ? 'Deactivate' : 'Activate'}
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
                tbody.append(row);
            });

            renderPagination(response);
        }
    });
}

function renderPagination(data) {
    let pagination = $('#pagination');
    pagination.empty();

    // Previous button
    if (data.prev_page_url) {
        pagination.append(`<button class="page-btn" data-page="${data.current_page - 1}">Prev</button>`);
    }

    // Page numbers
    for (let i = 1; i <= data.last_page; i++) {
        pagination.append(`
            <button class="page-btn ${i === data.current_page ? 'active' : ''}" data-page="${i}">${i}</button>
        `);
    }

    // Next button
    if (data.next_page_url) {
        pagination.append(`<button class="page-btn" data-page="${data.current_page + 1}">Next</button>`);
    }
}

loadCategories();

$(document).on('click', '.page-btn', function() {
    let page = $(this).data('page');
    loadCategories(page);
});



// STATUS DROPDOWN
const statusBtn = document.getElementById('statusDropdownBtn');
const statusMenu = document.getElementById('statusDropDownMenu');

statusBtn.addEventListener('click', () => {
    statusMenu.classList.toggle('hidden');
});

// CATEGORY ADD | RESET FORM
$('#addCategoryBtn').on('click', function () {
    $formTitle.text('Add Category'); // ADD TITLE

    // SHOW FORM ANIMATION
    formAnimation('hidden', 'flex', 'animate-slide-in', 'animate-slide-out'); 

    // RESET FORM FIELDS
    $form.trigger("reset"); // CLEAR ALL INPUTS
    $('#id').val(""); // ENSURE HIDDEN ID IS CLEARED
});

// CANCEL FORM
$('#cancelBtn').on('click', function() {
    formAnimationOut();
});

// CATEGORY SAVE CHANGES FORM
$("#categoryForm").on('submit', function(event) {
    event.preventDefault();

    let form = $("#categoryForm")[0];
    let data = new FormData(form);

    $.ajax({
        type: "POST",
        url: `${window.location.origin}/categories`,
        data: data,
        processData: false,
        contentType: false,
        success: function(data) {
            formAnimationOut();
            loadCategories();
        },
        error: function(xhr) {
            $("#output").text(xhr.responseText);
        }
    });
});

// CATEGORY EDIT | FETCH DATA FORM 
$(document).on('click', '.edit-btn', function() {
    const encryptedId = $(this).data('id');

    $.ajax({
        type: 'GET',
        url: `${window.location.origin}/categories/${encryptedId}`,
        success: function(response) {
            formAnimation('hidden', 'flex', 'animate-slide-in', 'animate-slide-out');

            $('#form-title').text('Edit Category'); // EDIT TITLE

            $('#id').val(encryptedId);
            $('#name').val(response.category.name);
            $('#status').val(response.category.status);
        },
        error: function(xhr) {
            alert('Failed to fetch user data.');
        }
    });
});

// CATEGORY DELETE | FETCH ID FORM | ALERT
$(document).on('click', '.delete-btn', function() {
    const encryptedId = $(this).data('id');

    const deleteConfirmation = $('.delete-confirmation');
    
    // Show delete confirmation
    deleteConfirmation.removeClass('hidden animate-slide-out')
                      .addClass('animate-slide-in');

    // Set the ID in hidden field (para sa form submission)
    deleteConfirmation.find('input[name="id"]').val(encryptedId); 
});