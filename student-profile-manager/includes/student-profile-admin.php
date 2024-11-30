<?php
// Add menu page
add_action('admin_menu', 'spm_add_admin_menu');
function spm_add_admin_menu() {
    add_menu_page(
        'Student Profiles',
        'Student Profiles',
        'manage_options',
        'student-profiles',
        'spm_admin_page_contents',
        'dashicons-groups',
        30
    );
}

// Admin page contents
function spm_admin_page_contents() {
    if (!current_user_can('manage_options')) {
        return;
    }

    $errors = array();
    $success_message = '';

    
    if (isset($_POST['submit'])) {
    if ($_POST['action'] != 'delete'){
        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $phone = sanitize_text_field($_POST['phone']);
        $date_of_birth = sanitize_text_field($_POST['date_of_birth']);
        $student_id = sanitize_text_field($_POST['student_id']);
        $address = sanitize_textarea_field($_POST['address']);
        $course = sanitize_text_field($_POST['course']);

    
        if (empty($name)) {
            $errors[] = 'Name is required.';
        }
        if (empty($email) || !is_email($email)) {
            $errors[] = 'Valid email is required.';
        }
        if (empty($date_of_birth)) {
            $errors[] = 'Date of birth is required.';
        }
        if (empty($student_id)) {
            $errors[] = 'Student ID is required.';
        }
        if (empty($address)) {
            $errors[] = 'Address is required.';
        }
        if (empty($course)) {
            $errors[] = 'Course is required.';
        }

        }elseif ($_POST['action'] == 'delete') {
                spm_delete_student_profile($_POST['id']);
                $success_message = 'Profile deleted successfully.';
            }
   

        if (empty($errors)) {
            if ($_POST['action'] == 'create') {
                spm_create_student_profile(
                    $name,
                    $email,
                    $phone,
                    $date_of_birth,
                    $student_id,
                    $address,
                    $course
                );
                $success_message = 'Profile created successfully.';
            } elseif ($_POST['action'] == 'update') {
                spm_update_student_profile(
                    $_POST['id'],
                    $name,
                    $email,
                    $phone,
                    $date_of_birth,
                    $student_id,
                    $address,
                    $course
                );
                $success_message = 'Profile updated successfully.';
            } elseif ($_POST['action'] == 'delete') {
                spm_delete_student_profile($_POST['id']);
                $success_message = 'Profile deleted successfully.';
            }
        }
    
    }

    $profiles = spm_get_all_student_profiles();
    ?>
    <div class="wrap">
        <h1>Student Profiles</h1>
        <?php if (!empty($errors)): ?>
            <div class="error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <?php if (!empty($success_message)): ?>
            <div class="updated">
                <p><?php echo $success_message; ?></p>
            </div>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="create">
            <label for="name">Name:</label>
            <input type="text" name="name" required>
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            <label for="phone">Phone:</label>
            <input type="text" name="phone">
            <label for="date_of_birth">Date of Birth:</label>
            <input type="date" name="date_of_birth" required>
            <label for="student_id">Student ID:</label>
            <input type="text" name="student_id" required>
            <label for="address">Address:</label>
            <textarea name="address" required></textarea>
            <label for="course">Course:</label>
            <input type="text" name="course" required>
            <input type="submit" name="submit" value="Create Profile">
        </form>

        <h2>Existing Profiles</h2>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Date of Birth</th>
                    <th>Student ID</th>
                    <th>Address</th>
                    <th>Course</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($profiles as $profile): ?>
                    <tr>
                        <td><?php echo $profile->id; ?></td>
                        <td><?php echo $profile->name; ?></td>
                        <td><?php echo $profile->email; ?></td>
                        <td><?php echo $profile->phone; ?></td>
                        <td><?php echo $profile->date_of_birth; ?></td>
                        <td><?php echo $profile->student_id; ?></td>
                        <td><?php echo $profile->address; ?></td>
                        <td><?php echo $profile->course; ?></td>
                        <td>
                            <button class="spm-edit-profile" style="padding: 10px 20px;
  background-color: #0073aa;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;" data-id="<?php echo $profile->id; ?>">Edit</button>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $profile->id; ?>">
                                <input type="submit" name="submit" value="Delete" onclick="return confirm('Are you sure?')">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Edit Profile Dialog -->
    <div id="spm-edit-dialog" style="display:none;">
        <form id="spm-edit-form" enctype="multipart/form-data">
            <input type="hidden" id="spm-edit-id" name="id">
            <label for="spm-edit-name">Name:</label>
            <input type="text" id="spm-edit-name" name="name" required>
            <label for="spm-edit-email">Email:</label>
            <input type="email" id="spm-edit-email" name="email" required>
            <label for="spm-edit-phone">Phone:</label>
            <input type="text" id="spm-edit-phone" name="phone">
            <label for="spm-edit-date_of_birth">Date of Birth:</label>
            <input type="date" id="spm-edit-date_of_birth" name="date_of_birth" required>
            <label for="spm-edit-student_id">Student ID:</label>
            <input type="text" id="spm-edit-student_id" name="student_id" required>
            <label for="spm-edit-address">Address:</label>
            <textarea id="spm-edit-address" name="address" required></textarea>
            <label for="spm-edit-course">Course:</label>
            <input type="text" id="spm-edit-course" name="course" required>
            
        </form>
    </div>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            var $dialog = $('#spm-edit-dialog');
            var $form = $('#spm-edit-form');

            $('.spm-edit-profile').on('click', function() {
                var profileId = $(this).data('id');
                $.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'POST',
                    data: {
                        action: 'spm_get_profile',
                        id: profileId
                    },
                    success: function(response) {
                        var profile = JSON.parse(response);
                        $('#spm-edit-id').val(profile.id);
                        $('#spm-edit-name').val(profile.name);
                        $('#spm-edit-email').val(profile.email);
                        $('#spm-edit-phone').val(profile.phone);
                        $('#spm-edit-date_of_birth').val(profile.date_of_birth);
                        $('#spm-edit-student_id').val(profile.student_id);
                        $('#spm-edit-address').val(profile.address);
                        $('#spm-edit-course').val(profile.course);
                        $dialog.dialog({
                            modal: true,
                            title: 'Edit Profile',
                            width: 500,
                            buttons: {
                                'Save': function() {
                                    var formData = new FormData($form[0]);
                                    formData.append('action', 'spm_update_profile');
                                    $.ajax({
                                        url: '<?php echo admin_url('admin-ajax.php'); ?>',
                                        type: 'POST',
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        success: function(response) {
                                            location.reload();
                                        }
                                    });
                                    $(this).dialog('close');
                                },
                                'Cancel': function() {
                                    $(this).dialog('close');
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>
    <?php
}

// AJAX handler to get profile data
add_action('wp_ajax_spm_get_profile', 'spm_get_profile_ajax');
function spm_get_profile_ajax() {
    $id = intval($_POST['id']);
    $profile = spm_get_student_profile($id);
    echo json_encode($profile);
    wp_die();
}

// AJAX handler to update profile data
add_action('wp_ajax_spm_update_profile', 'spm_update_profile_ajax');
function spm_update_profile_ajax() {
    $id = intval($_POST['id']);
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $date_of_birth = sanitize_text_field($_POST['date_of_birth']);
    $student_id = sanitize_text_field($_POST['student_id']);
    $address = sanitize_textarea_field($_POST['address']);
    $course = sanitize_text_field($_POST['course']);


    spm_update_student_profile(
        $id,
        $name,
        $email,
        $phone,
        $date_of_birth,
        $student_id,
        $address,
        $course,
    );

    wp_die();
}

// Shortcode to display student profiles on the frontend
add_shortcode('student_profiles_table', 'spm_frontend_student_profiles_table');
function spm_frontend_student_profiles_table() {
    $profiles = spm_get_all_student_profiles();
    ob_start();
    ?>
    <table class="spm-frontend-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date of Birth</th>
                <th>Student ID</th>
                <th>Address</th>
                <th>Course</th>
                
            </tr>
        </thead>
        <tbody>
            <?php foreach ($profiles as $profile): ?>
                <tr>
                    <td><?php echo $profile->id; ?></td>
                    <td><?php echo $profile->name; ?></td>
                    <td><?php echo $profile->email; ?></td>
                    <td><?php echo $profile->phone; ?></td>
                    <td><?php echo $profile->date_of_birth; ?></td>
                    <td><?php echo $profile->student_id; ?></td>
                    <td><?php echo $profile->address; ?></td>
                    <td><?php echo $profile->course; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
    return ob_get_clean();
}