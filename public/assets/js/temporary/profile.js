document.addEventListener('DOMContentLoaded', function() {
    // Initialize elements using the selectors from PHP
    const editProfileBtn = document.querySelector('.edit-profile-btn');
    const cancelBtn = document.querySelector('.cancel-btn');
    const saveBtn = document.querySelector('.save-btn');
    const actionButtons = document.querySelector('.action-buttons');
    const formInputs = document.querySelectorAll('.form-input');
    const profileImageWrapper = document.querySelector('.profile-image-wrapper');
    const profileImageOverlay = document.querySelector('.profile-image-overlay');
    const profileImage = document.querySelector('.profile-image');
    const imageModal = document.querySelector('.image-modal');
    const modalCloseBtn = document.querySelector('.modal-close-btn');
    const fileInput = document.getElementById('profileImage');
    const modalCancelBtn = document.querySelector('.modal-cancel-btn');
    const uploadLabel = document.querySelector('.upload-label');
    const modalUploadBtn = document.querySelector('.modal-upload-btn');

    // Toggle edit mode
    let isEditMode = false;
    
    editProfileBtn.addEventListener('click', function() {
        isEditMode = !isEditMode;
        
        if (isEditMode) {
            // Enable editing
            formInputs.forEach(input => {
                input.removeAttribute('readonly');
                input.classList.remove('bg-gray-50');
                input.classList.add('bg-white');
            });
            
            actionButtons.classList.remove('hidden');
            editProfileBtn.querySelector('.edit-text').textContent = 'بازگشت';
            editProfileBtn.querySelector('.edit-icon').className = 'fas fa-arrow-left';
        } else {
            // Disable editing
            formInputs.forEach(input => {
                input.setAttribute('readonly', 'readonly');
                input.classList.add('bg-gray-50');
                input.classList.remove('bg-white');
            });
            
            actionButtons.classList.add('hidden');
            editProfileBtn.querySelector('.edit-text').textContent = 'ویرایش پروفایل';
            editProfileBtn.querySelector('.edit-icon').className = 'fas fa-edit';
        }
    });
    
    // Cancel button resets to view mode
    cancelBtn.addEventListener('click', function() {
        isEditMode = false;
        formInputs.forEach(input => {
            input.setAttribute('readonly', 'readonly');
            input.classList.add('bg-gray-50');
            input.classList.remove('bg-white');
        });
        actionButtons.classList.add('hidden');
        editProfileBtn.querySelector('.edit-text').textContent = 'ویرایش پروفایل';
        editProfileBtn.querySelector('.edit-icon').className = 'fas fa-edit';
    });
    
    // Save button functionality
    saveBtn.addEventListener('click', function() {
        // Here you would typically send data to server via AJAX
        alert('تغییرات با موفقیت ذخیره شد');
        isEditMode = false;
        formInputs.forEach(input => {
            input.setAttribute('readonly', 'readonly');
            input.classList.add('bg-gray-50');
            input.classList.remove('bg-white');
        });
        actionButtons.classList.add('hidden');
        editProfileBtn.querySelector('.edit-text').textContent = 'ویرایش پروفایل';
        editProfileBtn.querySelector('.edit-icon').className = 'fas fa-edit';
    });
    
    // Profile image hover effect
    profileImageWrapper.addEventListener('mouseenter', function() {
        if (!isEditMode) return;
        profileImageOverlay.style.opacity = '1';
    });
    
    profileImageWrapper.addEventListener('mouseleave', function() {
        profileImageOverlay.style.opacity = '0';
    });
    
    // Open image modal when clicking on profile image
    profileImageWrapper.addEventListener('click', function() {
        if (!isEditMode) return;
        imageModal.classList.remove('hidden');
    });
    
    // Close modal buttons
    modalCloseBtn.addEventListener('click', function() {
        imageModal.classList.add('hidden');
    });
    
    modalCancelBtn.addEventListener('click', function() {
        imageModal.classList.add('hidden');
    });
    
    // Handle file selection
    fileInput.addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(event) {
                profileImage.src = event.target.result;
                // Here you would typically upload the image to the server
            };
            
            reader.readAsDataURL(e.target.files[0]);
            imageModal.classList.add('hidden');
        }
    });
    
    // Upload button in modal
    modalUploadBtn.addEventListener('click', function() {
        fileInput.click();
    });
    
    // Drag and drop functionality
    uploadLabel.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('border-indigo-500', 'bg-indigo-50');
    });
    
    uploadLabel.addEventListener('dragleave', function() {
        this.classList.remove('border-indigo-500', 'bg-indigo-50');
    });
    
    uploadLabel.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('border-indigo-500', 'bg-indigo-50');
        
        if (e.dataTransfer.files && e.dataTransfer.files[0]) {
            fileInput.files = e.dataTransfer.files;
            const event = new Event('change');
            fileInput.dispatchEvent(event);
        }
    });
});