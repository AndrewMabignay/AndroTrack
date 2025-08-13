<x-layout :page="'category'">
    <section class="category-section">
        <header class="authentication-header">
            {{-- EMAIL --}}
            <button id="emailBtn">
                <i class="fas fa-envelope"></i>
            </button>

            {{-- NOTIFICATION --}}
            <button id="notificationBtn">
                <i class="fas fa-bell"></i>
            </button>

            {{-- SETTINGS --}}
            <button id="settingBtn">
                <i class="fas fa-cog"></i>
            </button>

            {{-- PROFILE --}}
            <img src="../public/img/image.png" alt="" class="profile-image">
        </header>

        {{-- HEADER CONTAINER --}}
        <header class="category-management-header">

            {{-- CATEGORY LIST TITLE --}}
            <h2 class="title-container">
                Category Management
            </h2>

            {{-- CATEGORY BUTTON & REFRESH CONTAINER --}}
            <div class="add-refresh-container">

                {{-- REFRESH --}}
                <button type="button" class="refreshBtn">
                    <i class="fas fa-sync-alt"></i>
                </button>

                {{-- CREATE --}}
                <button type="button" id="addCategoryBtn" class="addCategoryBtn">
                    <i class="fas fa-plus"></i>
                    Add Category
                </button>
            </div>
        </header>

        {{-- CATEGORY TABLE WRAPPER --}}
        <div class="table-wrapper">

            {{-- SEARCH & DISPLAY CONTAINER --}}
            <div class="search-display-container">

                {{-- SEARCH CONTAINER --}}
                <div class="search-container">
                    <button class="searchBtn">
                        <i class="fas fa-search"></i>
                    </button>
                    <input type="text" id="searchInput" placeholder="Search">
                </div>

                {{-- ROLE STATUS CONTAINER --}}
                <div class="status-container">

                    {{-- STATUS DROPDOWN --}}
                    <div class="relative">

                        {{-- STATUS DROPDOWN BUTTON --}}
                        <button type="button" id="statusDropdownBtn" class="status-dropdown-btn">
                            Status
                            <i class="fas fa-chevron-down"></i>
                        </button>

                        {{-- STATUS DROPDOWN CONTAINER --}}
                        <div id="statusDropDownMenu" class="status-dropdown-menu hidden">
                            <button>All</button>
                            <button>Active</button>
                            <button>Inactive</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CATEGORY TABLE --}}
            <table class="category-table" id="category-table">

                {{-- CATEGORY TABLE HEAD --}}
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category</th>
                        <th>Category slug</th>
                        <th>Created On</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                {{-- CATEGORY TABLE BODY --}}
                <tbody>

                </tbody>
            </table>

            <div class="per-page-container">
                    <select id="perPage">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>

            <div id="pagination" class="pagination-container">
                
            </div>
        </div>

        {{-- OVERLAY | CATEGORY FORM --}}
        <div id="overlay" class="overlay hidden">
            
            {{-- CATEGORY FORM --}}
            <form id="categoryForm">
                @csrf

                {{-- TITLE CONTAINER --}}
                <div class="title-container">
                    <h2 id="form-title">Add Category</h2>

                    {{-- REFRESH FORM --}}
                    <button id="refreshFormBtn" class="refresh-form-btn" type="button">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>

                <hr>

                {{-- CATEGORY ID --}}
                <input type="hidden" id="id" name="id">

                {{-- INPUT FIELDS CONTAINER --}}
                <div class="input-fields-container">
                
                    {{-- CATEGORY NAME --}}
                    <div class="input-container">
                        <label for="name">Category</label>
                        <input type="text" name="name" id="name">
                        <span id="categoryNameErrorOutput"></span>
                    </div>

                    {{-- CATEGORY STATUS --}}
                    <div class="input-container">
                        <label for="status">Status</label>
                        <select name="status" id="status">
                            <option value="active" selected>Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <span id="categoryNameErrorOutput"></span>
                    </div>
                </div>
                
                <hr>

                <span id="output">

                </span>

                {{-- BUTTON CONTAINER --}}
                <div class="button-container">

                    {{-- CANCEL BUTTON --}}
                    <button type="button" id="cancelBtn" class="cancel-btn">
                        <i class="fas fa-times"></i>
                        Cancel
                    </button>
                    
                    {{-- SAVE CHANGES BUTTON --}}
                    <button type="submit" id="saveChangesBtn" class="save-changes-btn">
                        <i class="fas fa-save"></i>
                        Save changes
                    </button>
                </div>
            </form>

            {{-- POP OUT DELETE CONFIRMATION --}}
            <div class="delete-confirmation hidden">
                <form id="deleteCategoryFormAlert">
                    @csrf

                    {{-- CATEGORY DELETE ID --}}
                    <input type="hidden" id="id" name="id">
                    
                    {{-- DELETE CONTAINER --}}
                    <div class="delete-container-field flex flex-col items-center gap-4">
                        <i class="fas fa-trash text-3xl"></i>

                        <p class="text-[15px] text-center leading-loose w-[300px]">
                            Are you sure you want to delete this 
                            <span id="deleteCategoryItem"><b>Technology</b></span>
                            category?
                        </p>
                    </div>

                    {{-- BUTTON CONTAINER --}}
                    <div class="button-container">
                        <button type="button" id="noBtn" class="no-btn">
                            No
                        </button>

                        <button type="submit" id="yesBtn" class="yes-btn">
                            Yes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-layout>