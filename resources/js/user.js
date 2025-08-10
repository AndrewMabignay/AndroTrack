import $ from 'jquery';
window.$ = window.jQuery = $;

// PREVIEW IMAGE
function previewImage(event) {
    const file = event.target.files[0];
    const reader = new FileReader();

    reader.onload = function(e) {
        document.getElementById('preview').src = e.target.result;
    }

    if (file) {
        reader.readAsDataURL(file);
    }
}

function renderPagination(users) {
    let pagination = $('.pagination');
    pagination.empty();

    for (let page = 1; page <= users.last_page; page++) {
        const button = `<button class="pagination-btn" data-page="${page}">${page}</button>`;
        pagination.append(button);
    }

    $(document).on('click', '.pagination-btn', function () {
        const selectedPage = $(this).data('page');
        loadUsers(selectedPage);
    });

}


$(document).ready(function() {
    const $overlay = $('#overlay');
    const $form = $('#userForm');
    const $formTitle = $('#form-title');

    // FORM ANIMATION
    function formAnimation(classA, classB, animationA, animationB) {
        $overlay.removeClass(classA).addClass(classB);
                
        $form.addClass(animationA);

        $form[0].offsetWidth;
        $form.removeClass(animationB);
    }

    // DISPLAY FUNCTION
    // function loadUsers() {
    //     $.ajax({
    //         type: 'GET',
    //         url: `${window.location.origin}/user-list`,
    //         success: function(response) {
    //             let tbody = $('#user-table tbody');
    //             tbody.empty(); // CLEAR PREVIOUS DATA

    //             if (response.users.length === 0) {
    //                 let row = `
    //                     <tr>
    //                         <td colspan="7">
    //                             No users found.
    //                         </td>
    //                     <tr>
    //                 `;

    //                 tbody.append(row);
    //                 return;
    //             }

    //             response.users.forEach(function(user, index) {
    //                 let row = `
    //                     <tr>
    //                         <td>${index + 1}</td>
    //                         <td>${user.lastname}, ${user.firstname} ${user.middlename.charAt(0).toUpperCase()}</td>
    //                         <td>${user.username}</td>
    //                         <td>${user.email}</td>
    //                         <td>${user.role.charAt(0).toUpperCase() + user.role.slice(1)}</td>
    //                         <td>${user.status.charAt(0).toUpperCase() + user.status.slice(1)}</td>
    //                         <td>
    //                             <div class="button-action-container">
    //                                 <button type="button" class="view-btn"><i class="fas fa-eye"></i></button>
    //                                 <button type="button" class="edit-btn" data-id="${user.encrypted_id}">
    //                                     <i class="fas fa-edit"></i>
    //                                 </button>
    //                                 <button type="button" class="status-btn" data-id="${user.encrypted_id}">${user.status === 'active' ? 'Deactivate' : 'Activate'}</button>
    //                             </div>
    //                         </td>
    //                     <tr>
    //                 `;

    //                 tbody.append(row);
    //             });
    //         }
    //     });
    // }

    function loadUsers(page = 1) {
    $.ajax({
        type: 'GET',
        url: `${window.location.origin}/user-list?page=${page}`,
        success: function(response) {
            let tbody = $('#user-table tbody');
            tbody.empty();

            if (response.users.data.length === 0) {
                tbody.append('<tr><td colspan="7">No users found.</td></tr>');
                return;
            }

            response.users.data.forEach(function(user, index) {
                let row = `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${user.lastname}, ${user.firstname} ${user.middlename.charAt(0).toUpperCase()}</td>
                        <td>${user.username}</td>
                        <td>${user.email}</td>
                        <td>${user.role.charAt(0).toUpperCase() + user.role.slice(1)}</td>
                        <td>${user.status.charAt(0).toUpperCase() + user.status.slice(1)}</td>
                        <td>
                            <div class="button-action-container">
                                <button type="button" class="view-btn"><i class="fas fa-eye"></i></button>
                                <button type="button" class="edit-btn" data-id="${user.encrypted_id}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="status-btn" data-id="${user.encrypted_id}">
                                    ${user.status === 'active' ? 'Deactivate' : 'Activate'}
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
                tbody.append(row);
            });

            // Show pagination
            renderPagination(response.users);
        }
    });
}


    // DISPLAY USERS
    loadUsers();

    // TOGGLE STATUS
    $(document).on('click', '.status-btn', function() {
        const encryptedId = $(this).data('id');
        console.log(encryptedId);

        $.ajax({
            type: 'POST',
            url: `${window.location.origin}/users/${encryptedId}`,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                loadUsers();
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    });

    // ADD | RESET FORM
    $('#addUserBtn').on('click', function () {
        $formTitle.text('Add User'); // ADD TITLE

        // SHOW FORM ANIMATION
        formAnimation('hidden', 'flex', 'animate-slide-in', 'animate-slide-out'); 

        // RESET FORM FIELDS
        $form.trigger("reset"); // CLEAR ALL INPUTS
        $('#id').val(""); // ENSURE HIDDEN ID IS CLEARED
        $('#preview-image').attr('src', '../public/img/user.png'); // RESET IMAGE PREVIEW
        $('#file-name').text("No file selected"); // RESET FILE LABEL
    });

    // EDIT | FETCH DATA FORM 
    $(document).on('click', '.edit-btn', function() {
        const encryptedId = $(this).data('id');

        $.ajax({
            type: 'GET',
            url: `${window.location.origin}/user/${encryptedId}`,
            url: `/user/${encryptedId}`,
            success: function(user) {
                $('#overlay').removeClass('hidden').addClass('flex');

                // ADD ANIMATION
                const $form = $('#userForm');
                $form.removeClass('animate-slide-out');

                // FORCE REFLOW
                $form[0].offsetWidth;

                $form.addClass('animate-slide-in');

                $('#form-title').text('Edit User'); // EDIT TITLE

                $('#id').val(encryptedId);
                $("#preview-image").attr("src", `/storage/${user.profile_image}`);
                $('#file-name').text("Image loaded.");
                $('#firstname').val(user.firstname);
                $('#lastname').val(user.lastname);
                $('#middlename').val(user.middlename);
                $('#phone_number').val(user.phone_number);
                $('#username').val(user.username);
                $('#email').val(user.email);
                $('#role').val(user.role);
                $('#status').val(user.status);
            },
            error: function(xhr) {
                alert('Failed to fetch user data.');
            }
        });
    });

    // CANCEL FORM
    $('#cancelBtn').on('click', function() {
        $form.removeClass('animate-slide-in').addClass('animate-slide-out');

        // WAIT FOR THE ANIMATION TO FINISH
        setTimeout(() => {
            $overlay.removeClass('flex').addClass('hidden');
            $form.removeClass('animate-slide-out');
        }, 400); // ANIMATION DURATION
    });

    // SAVE CHANGES FORM
    $("#userForm").submit(function(event) {
        event.preventDefault();

        let form = $("#userForm")[0];
        let data = new FormData(form);

        $.ajax({
            type: "POST",
            url: `${window.location.origin}/users`,
            data: data,
            processData: false,
            contentType: false,
            success: function(data) {
                loadUsers();

                $overlay.removeClass('flex').addClass('hidden');
                
                // REMOVE FORM ANIMATION
                $form.addClass('animate-slide-in');

                // FORCE REFLOW
                $form[0].offsetWidth;
                $form.removeClass('animate-slide-out');
            },
            error: function(xhr) {
                $("#output").text(xhr.responseText);
            }
        });
    });
});

// ROLE DROPDOWN 
const roleBtn = document.getElementById('roleDropdownBtn');
const roleMenu = document.getElementById('roleDropDownMenu');

roleBtn.addEventListener('click', () => {
    roleMenu.classList.toggle('hidden');
});

// STATUS DROPDOWN
const statusBtn = document.getElementById('statusDropdownBtn');
const statusMenu = document.getElementById('statusDropDownMenu');

statusBtn.addEventListener('click', () => {
    statusMenu.classList.toggle('hidden');
});