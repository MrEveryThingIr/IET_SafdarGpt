<?php
$selectors = [
    // Main elements
    'editProfileBtn' => 'edit-profile-btn', // Edit profile button - class
    'cancelBtn' => 'cancel-btn', // Cancel edit button - class
    'saveBtn' => 'save-btn', // Save changes button - class
    'actionButtons' => 'action-buttons', // Action buttons container - class
    
    // Form inputs
    'formInputs' => 'form-input', // All form input fields - class
    
    // Profile image elements
    'profileImageWrapper' => 'profile-image-wrapper', // Profile image container - class
    'profileImageOverlay' => 'profile-image-overlay', // Profile image hover overlay - class
    'profileImage' => 'profile-image', // Profile image element - class
    
    // Modal elements
    'imageModal' => 'image-modal', // Image upload modal - class
    'modalCloseBtn' => 'modal-close-btn', // Modal close button - class
    'fileInput' => 'profileImage', // File input for image upload  - ID
    'modalCancelBtn' => 'modal-cancel-btn', // Modal cancel button  - class
    'uploadLabel' => 'upload-label', // Upload label/area  - class
];
?>
<a href="<?php echo route('profile.change_password') ?>"></a>---------->embed this link professionally in this page at the best place with best practices
<?php
 $user_data=$data['user_info'] ;
 $userAge=$data['userAge'];   
?>
    <div class="min-h-screen">
        <!-- Header -->
        <header class="profile-header bg-gradient-to-r from-blue-600 to-indigo-700 shadow-lg">
            <div class="header-container max-w-6xl mx-auto px-4 py-6 flex justify-between items-center">
                <h1 class="header-title text-2xl font-bold text-white">پروفایل کاربری</h1>
                <button class="<?php echo $selectors['editProfileBtn'] ?> bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                    <i class="edit-icon fas fa-edit"></i>
                    <span class="edit-text">ویرایش پروفایل</span>
                </button>
            </div>
        </header>

        <!-- Main Content -->
        <main class="profile-main max-w-6xl mx-auto px-4 py-8">
            <div class="profile-grid grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Sidebar - Profile Card -->
                <div class="profile-sidebar lg:col-span-1">
                    <div class="profile-card bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                        <div class="profile-card-header relative">
                            <!-- Profile Cover -->
                            <div class="profile-cover h-32 bg-gradient-to-r from-blue-400 to-indigo-500"></div>
                            
                            <!-- Profile Picture -->
                            <div class="profile-picture-container absolute -bottom-16 left-1/2 transform -translate-x-1/2">
                                <div class="<?php echo $selectors['profileImageWrapper'] ?> relative">
                                    <img src="<?= $user_data['img'] ?>" 
                                         alt="Profile" 
                                         class="profile-image w-32 h-32 rounded-full border-4 border-white object-cover shadow-md">
                                    <div class="<?php echo $selectors['profileImageOverlay'] ?> absolute inset-0 bg-black/50 rounded-full flex items-center justify-center opacity-0 transition-opacity cursor-pointer">
                                        <i class="profile-image-upload-icon fas fa-camera text-white text-2xl"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Profile Info -->
                        <div class="profile-info pt-20 pb-6 px-4 text-center">
                            <h2 class="profile-name text-xl font-bold text-gray-800"><?= $user_data['firstname'] . ' ' . $user_data['lastname'] ?></h2>
                            <p class="profile-username text-gray-600 text-sm mt-1">@<?= $user_data['username'] ?></p>
                            <p class="profile-role text-indigo-600 font-medium mt-2"><?= $user_data['role'] ?></p>
                            
                            <div class="profile-stats mt-4 flex justify-center space-x-4">
                                <div class="stat-item text-center">
                                    <div class="stat-value text-gray-800 font-bold"><?= $userAge ?></div>
                                    <div class="stat-label text-gray-500 text-xs">سن</div>
                                </div>
                                <div class="stat-item text-center">
                                    <div class="stat-value text-gray-800 font-bold"><?= $user_data['gender'] === 'male' ? 'مرد' : 'زن' ?></div>
                                    <div class="stat-label text-gray-500 text-xs">جنسیت</div>
                                </div>
                            </div>
                        </div>
                    </div>

                        <!-- Change Password Link -->
    <div class="mt-6 text-center">
        <a href="<?= route('profile.change_password') ?>"
           class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800 transition duration-200">
            <i class="fas fa-lock mr-1"></i>
            تغییر گذرواژه
        </a>
    </div>
                </div>

                <!-- Main Profile Content -->
                <div class="profile-content lg:col-span-3 space-y-6">
                    <!-- About Card -->
                    <div class="about-card bg-white rounded-xl shadow-md p-6">
                        <div class="card-header flex justify-between items-center mb-4">
                            <h2 class="card-title text-xl font-bold text-gray-800">اطلاعات شخصی</h2>
                            <i class="card-icon fas fa-user text-indigo-500"></i>
                        </div>
                        
                        <div class="card-body space-y-4">
                            <div class="form-grid grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="form-group">
                                    <label class="form-label block text-sm font-medium text-gray-700 mb-1">نام</label>
                                    <input type="text" value="<?= $user_data['firstname'] ?>" 
                                           class="<?php echo $selectors['formInputs'] ?> w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-gray-50" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="form-label block text-sm font-medium text-gray-700 mb-1">نام خانوادگی</label>
                                    <input type="text" value="<?= $user_data['lastname'] ?>" 
                                           class="<?php echo $selectors['formInputs'] ?> w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-gray-50" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="form-label block text-sm font-medium text-gray-700 mb-1">نام کاربری</label>
                                    <input type="text" value="<?= $user_data['username'] ?>" 
                                           class="<?php echo $selectors['formInputs'] ?> w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-gray-50" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="form-label block text-sm font-medium text-gray-700 mb-1">تاریخ تولد</label>
                                    <input type="text" value="<?= $user_data['birthdate'] ?>" 
                                           class="<?php echo $selectors['formInputs'] ?> w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-gray-50" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Card -->
                    <div class="contact-card bg-white rounded-xl shadow-md p-6">
                        <div class="card-header flex justify-between items-center mb-4">
                            <h2 class="card-title text-xl font-bold text-gray-800">اطلاعات تماس</h2>
                            <i class="card-icon fas fa-address-book text-indigo-500"></i>
                        </div>
                        
                        <div class="card-body space-y-4">
                            <div class="form-grid grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="form-group">
                                    <label class="form-label block text-sm font-medium text-gray-700 mb-1">ایمیل</label>
                                    <input type="email" value="<?= $user_data['email'] ?>" 
                                           class="<?php echo $selectors['formInputs'] ?> w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-gray-50" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="form-label block text-sm font-medium text-gray-700 mb-1">شماره تلفن</label>
                                    <input type="tel" value="<?= $user_data['phone'] ?>" 
                                           class="<?php echo $selectors['formInputs'] ?> w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-gray-50" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Professional Info Card -->
                    <div class="professional-card bg-white rounded-xl shadow-md p-6">
                        <div class="card-header flex justify-between items-center mb-4">
                            <h2 class="card-title text-xl font-bold text-gray-800">اطلاعات شغلی</h2>
                            <i class="card-icon fas fa-briefcase text-indigo-500"></i>
                        </div>
                        
                        <div class="card-body space-y-4">
                            <div class="form-group">
                                <label class="form-label block text-sm font-medium text-gray-700 mb-1">شغل اصلی</label>
                                <input type="text" value="<?= $user_data['main_job'] ?>" 
                                       class="<?php echo $selectors['formInputs'] ?> w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-gray-50" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons (Hidden in view mode) -->
                    <div class="<?php echo $selectors['actionButtons'] ?> hidden flex justify-end space-x-3">
                        <button class="<?php echo $selectors['cancelBtn'] ?> px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                            انصراف
                        </button>
                        <button class="<?php echo $selectors['saveBtn'] ?> px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition flex items-center gap-2">
                            <i class="fas fa-save"></i>
                            ذخیره تغییرات
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Image Upload Modal (Hidden) -->
    <div class="<?php echo $selectors['imageModal'] ?> fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
        <div class="modal-content bg-white rounded-xl shadow-xl w-full max-w-md p-6">
            <div class="modal-header flex justify-between items-center mb-4">
                <h3 class="modal-title text-lg font-bold text-gray-800">تغییر تصویر پروفایل</h3>
                <button class="<?php echo $selectors['modalCloseBtn'] ?> text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="modal-body space-y-4">
                <div class="upload-container border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                    <input type="file" id="<?php echo $selectors['fileInput'] ?>" class="file-input hidden" accept="image/*">
                    <label for="profileImage" class="<?php echo $selectors['uploadLabel'] ?> cursor-pointer block">
                        <i class="upload-icon fas fa-cloud-upload-alt text-4xl text-indigo-500 mb-2"></i>
                        <p class="upload-text text-gray-600">برای آپلود تصویر کلیک کنید یا آن را اینجا رها کنید</p>
                        <p class="upload-hint text-sm text-gray-500 mt-2">فرمت‌های مجاز: JPG, PNG, GIF (حداکثر 2MB)</p>
                    </label>
                </div>
                
                <div class="modal-actions flex justify-end space-x-3">
                    <button class="<?php echo $selectors['modalCancelBtn'] ?> px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                        انصراف
                    </button>
                    <button class="modal-upload-btn px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                        آپلود تصویر
                    </button>
                </div>
            </div>
        </div>
    </div>
