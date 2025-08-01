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

// ---------------- FORM ----------------
const overlayForm = document.getElementById('overlay');

// ADD FORM
const addUserBtn = document.getElementById('addUserBtn');
addUserBtn.addEventListener('click', () => {
    overlayForm.classList.remove('hidden');
    overlayForm.classList.add('flex');

    // Add animation
    const form = overlayForm.querySelector('form');
    form.classList.remove('animate-slide-out');
    
    
    void form.offsetWidth;
    form.classList.add('animate-slide-in');
});

// CANCEL FORM
const cancelBtn = document.getElementById('cancelBtn');
cancelBtn.addEventListener('click', () => {
    const form = overlayForm.querySelector('form');
    form.classList.remove('animate-slide-in');
    void form.offsetWidth;
    form.classList.add('animate-slide-out');

    // Delay hiding the overlay until after animation ends (400ms)
    setTimeout(() => {
        overlayForm.classList.remove('flex');
        overlayForm.classList.add('hidden');
    }, 400); // must match animation duration
});

document.getElementById('lastname').value = 'Testing';
