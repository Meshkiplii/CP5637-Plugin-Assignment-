# CP5637-Plugin-Assignment-
The Student Profile Manager plugin is designed to help educational institutions manage student information and course registration records efficiently. With this plugin, schools can easily post names of students along with their registration details. Each time a student logs in, they can instantly see if they are registered in their respective courses.

## Features
- Manage student profiles with CRUD (Create, Read, Update, Delete) operations.
- Display student profiles on the frontend using a shortcode.
- Use intuitive user forms for data entry and management.
- Edit profiles through a user-friendly modal dialog.

## Installation

1. Download the Student Profile Manager plugin.
2. Upload the plugin files to the `/wp-content/plugins/student-profile-manager` directory, or install the plugin through the WordPress plugins screen directly.
3. Activate the plugin through the 'Plugins' screen in WordPress.
4. Navigate to the 'Student Profiles' menu item in the WordPress admin to start managing student profiles.

## Shortcode Usage

To display student profiles on the frontend, use the following shortcode in your posts or pages:
[student_profiles_table]


## How to Edit the Plugin

If you need to modify or extend the functionality of the Student Profile Manager plugin, follow these steps:

1. **Locate the Plugin Files**:
   The plugin files are located in the `/wp-content/plugins/student-profile-manager` directory of your WordPress installation.

2. **Editing the Admin Page**:
   The main admin page content is handled by the `spm_admin_page_contents` function in the `includes/student-profile-admin.php` file. This is where you can add, edit, or delete student profiles.

3. **Handling CRUD Operations**:
   CRUD operations are managed by various functions within the `includes` directory. For example:
   - `spm_create_student_profile($name, $email, $phone, $date_of_birth, $student_id, $address, $course)`
   - `spm_update_student_profile($id, $name, $email, $phone, $date_of_birth, $student_id, $address, $course)`
   - `spm_delete_student_profile($id)`
   - `spm_get_all_student_profiles()`

4. **AJAX Handlers**:
   AJAX handlers for retrieving and updating profile data are located in the `js/student-profile-manager.js` file. These handlers process AJAX requests sent from the admin page and perform the necessary database operations.

5. **Frontend Display**:
   The shortcode `[student_profiles_table]` is registered in the `includes/student-profile-admin.php` file. This shortcode generates the table displaying student profiles on the frontend.

6. **Adding New Features**:
   To add new features or modify existing ones, you can:
   - Edit the existing functions to handle new data fields or validation rules.
   - Add new functions and hooks to extend the plugin's capabilities.

## Support

If you encounter any issues or have any questions, feel free to contact me.

---


