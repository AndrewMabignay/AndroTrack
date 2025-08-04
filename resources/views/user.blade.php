<x-layout>
    <section class="user-management-section">
        <header class="authentication-header">
            <!-- EMAIL -->
            <button id="emailBtn">
                <i class="fas fa-envelope"></i>
            </button>

            <!-- NOTIFICATION -->
            <button id="notificationBtn">
                <i class="fas fa-bell"></i>
            </button>

            <!-- SETTINGS -->
            <button id="settingBtn">
                <i class="fas fa-cog"></i>
            </button>

            <!-- PROFILE -->
            <img src="../public/img/image.png" alt="" class="profile-image">
        </header>

        <!-- HEADER CONTAINER -->
        <header class="user-management-header">

            <!-- USER LIST TITLE  -->
            <h2 class="title-container">
                User Management
            </h2>

            <!-- USER BUTTON & REFRESH CONTAINER -->
            <div class="add-refresh-container">

                <!-- REFRESH -->
                <button type="button" class="refreshBtn">
                    <i class="fas fa-sync-alt"></i>
                </button>

                <!-- CREATE -->
                <button type="button" id="addUserBtn" class="addUserBtn">
                    <i class="fas fa-plus"></i>
                    Add User
                </button>
            </div>
        </header>

        <!-- USER TABLE WRAPPER -->
        <div class="table-wrapper">

            <!-- SEARCH & DISPLAY CONTAINER -->
            <div class="search-display-container">

                <!-- SEARCH CONTAINER -->
                <div class="search-container">
                    <button class="searchBtn">
                        <i class="fas fa-search"></i>
                    </button>
                    <input type="text" id="search" placeholder="Search">
                </div>

                <!-- ROLE STATUS CONTAINER -->
                <div class="role-status-container">

                    <!-- ROLE DROPDOWN -->
                    <div class="relative">
                        <!-- ROLE DROPDOWN BUTTON -->
                        <button type="button" id="roleDropdownBtn" class="role-dropdown-btn">
                            Role
                            <i class="fas fa-chevron-down"></i>
                        </button>

                        <!-- ROLE DROPDOWN CONTAINER -->
                        <div id="roleDropDownMenu" class="role-dropdown-menu hidden">
                            <button>Admin</button>
                            <button>Author</button>
                            <button>Editor</button>
                        </div>
                    </div>

                    <!-- STATUS DROPDOWN -->
                    <div class="relative">
                        <!-- STATUS DROPDOWN BUTTON -->
                        <button type="button" id="statusDropdownBtn" class="status-dropdown-btn">
                            Status
                            <i class="fas fa-chevron-down"></i>
                        </button>

                        <!-- STATUS DROPDOWN CONTAINER -->
                        <div id="statusDropDownMenu" class="status-dropdown-menu hidden">
                            <button>Active</button>
                            <button>Inactive</button>
                            <button>Banned</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- USER TABLE -->
            <table class="user-table" id="user-table">

                <!-- USER TABLE HEAD -->
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <!-- USER TABLE BODY -->
                <tbody>

                </tbody>
            </table>
        </div>

        <!-- OVERLAY | USER FORM -->
        <div id="overlay" class="overlay hidden">
            
            <!-- USER FORM -->
            <form id="userForm" enctype="multipart/form-data">
                @csrf

                <!-- TITLE CONTAINER -->
                <div class="title-container">
                    <h2 id="form-title">Add User</h2>

                    <!-- REFRESH FORM -->
                    <button id="refreshFormBtn" class="refresh-form-btn" type="button">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>

                <hr>

                {{-- USER ID --}}
                <input type="hidden" id="id" name="id">

                <!-- PERSONAL INFORMATION CONTAINER -->
                <div class="personal-information-container">
                    
                    <!-- IMAGE CONTAINER -->
                    <div class="image-container">

                        <!-- IMAGE PREVIEW -->
                        <img id="preview-image" src="../public/img/user.png" alt="Preview" class="preview-image"/>

                        <!-- FILE INPUT AND LABEL -->
                        <div class="upload-image">
                            <input id="file-upload" type="file" name="profile_image" accept="image/*" class="hidden" onchange="document.getElementById('preview-image').src = window.URL.createObjectURL(this.files[0])"/>
                            
                            <div class="upload-image-container">
                                <label for="file-upload">
                                    Upload Image
                                </label>
                                <span id="file-name">No file selected</span>
                            </div>
                        </div>
                    </div>

                    <!-- PERSONAL INFORMATION FIELDS -->
                    <div class="personal-information-fields">
                        <!-- FIRSTNAME -->
                        <div class="input-container">
                            <label for="firstname">First Name</label>
                            <input type="text" name="firstname" id="firstname" placeholder="Enter your firstname">
                        </div>

                        <!-- LASTNAME -->
                        <div class="input-container">
                            <label for="lastname">Last Name</label>
                            <input type="text" name="lastname" id="lastname" placeholder="Enter your lastname">
                        </div>

                        <!-- MIDDLE NAME -->
                        <div class="input-container">
                            <label for="middlename">Middle Name</label>
                            <input type="text" name="middlename" id="middlename" placeholder="Enter your middlename">
                        </div>

                        <!-- PHONE NUMBER -->
                        <div class="input-container">
                            <label for="phoneNumber">Phone Number</label>
                            <input type="text" name="phone_number" id="phone_number" placeholder="Enter your middlename">
                        </div>
                    </div>
                </div>
                
                <hr>

                <!-- INPUT FIELDS CONTAINER -->
                <div class="input-fields-container">
                
                    <!-- USERNAME -->
                    <div class="input-container">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" placeholder="Enter your username">
                    </div>

                    <!-- EMAIL -->
                    <div class="input-container">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" placeholder="Enter your email">
                    </div>

                    <!-- PASSWORD -->
                    <div class="input-container">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Enter your email">
                    </div>

                    <!-- CONFIRM PASSWORD -->
                    <div class="input-container">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Enter your email">
                    </div>

                    <!-- ROLE -->
                    <div class="input-container">
                        <label for="role">Role</label>
                        <select name="role" id="role">
                            <option value="">Select a role</option>
                            <option value="admin">Admin</option>
                            <option value="manager">Manager</option>
                            <option value="staff">Staff</option>
                            <option value="supplier">Supplier</option>
                        </select>
                    </div>

                    <!-- STATUS -->
                    <div class="input-container">
                        <label for="status">Status</label>
                        <select name="status" id="status">
                            <option value="">Select a status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                
                <hr>

                <span id="output">

                </span>

                <!-- BUTTON CONTAINER -->
                <div class="button-container">

                    <!-- CANCEL BUTTON -->
                    <button type="button" id="cancelBtn" class="cancel-btn">
                        <i class="fas fa-times"></i>
                        Cancel
                    </button>
                    
                    <!-- SAVE CHANGES BUTTON -->
                    <button type="submit" id="saveChangesBtn" class="save-changes-btn">
                        <i class="fas fa-save"></i>
                        Save changes
                    </button>
                </div>
            </form>
        </div>
    </section>

    <script>
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
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // DISPLAY FUNCTION
            function loadUsers() {
                $.ajax({
                    type: 'GET',
                    url: `${window.location.origin}/user-list`,
                    success: function(response) {
                        let tbody = $('#user-table tbody');
                        tbody.empty(); // CLEAR PREVIOUS DATA

                        if (response.users.length === 0) {
                            let row = `
                                <tr>
                                    <td colspan="7">
                                        No users found.
                                    </td>
                                <tr>
                            `;

                            tbody.append(row);
                            return;
                        }

                        response.users.forEach(function(user, index) {
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
                                            <button type="button" class="status-btn" data-id="${user.encrypted_id}">${user.status === 'active' ? 'Deactivate' : 'Activate'}</button>
                                        </div>
                                    </td>
                                <tr>
                            `;

                            tbody.append(row);
                        });
                    }
                });
            }

            // DISPLAY USER
            loadUsers();
        
            // ADD | RESET FORM
            $('#addUserBtn').on('click', function () {
                $('#overlay').removeClass('hidden').addClass('flex');

                $('#form-title').text('Add User'); // ADD TITLE

                const $form = $('#userForm');
                $form.removeClass('animate-slide-out');

                // Force reflow for animation
                $form[0].offsetWidth;

                $form.addClass('animate-slide-in');

                // RESET FORM FIELDS
                $form.trigger("reset"); // clears all inputs
                $('#id').val(""); // ensure hidden ID is cleared
                $('#preview-image').attr('src', '../public/img/user.png'); // reset image preview
                $('#file-name').text("No file selected"); // reset file label
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
                        $("#output").text(data.res);
                        loadUsers();
                    },
                    error: function(xhr) {
                        $("#output").text(xhr.responseText);
                    }
                });
            });

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



        });
    </script>
</x-layout>