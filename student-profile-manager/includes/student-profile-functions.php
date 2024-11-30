<?php
function spm_create_student_profile($name, $email, $phone, $date_of_birth, $student_id, $address, $course) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'student_profiles';

    $wpdb->insert(
        $table_name,
        array(
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'date_of_birth' => $date_of_birth,
            'student_id' => $student_id,
            'address' => $address,
            'course' => $course,
        )
    );

    return $wpdb->insert_id;
}

function spm_update_student_profile($id, $name, $email, $phone, $date_of_birth, $student_id, $address, $course) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'student_profiles';

    $wpdb->update(
        $table_name,
        array(
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'date_of_birth' => $date_of_birth,
            'student_id' => $student_id,
            'address' => $address,
            'course' => $course,
        ),
        array('id' => $id)
    );
}

function spm_delete_student_profile($id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'student_profiles';

    $wpdb->delete(
        $table_name,
        array('id' => $id)
    );
}

// Function to get a student profile by ID
function spm_get_student_profile($id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'student_profiles';

    return $wpdb->get_row("SELECT * FROM $table_name WHERE id = $id");
}

// Function to get all student profiles
function spm_get_all_student_profiles() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'student_profiles';

    return $wpdb->get_results("SELECT * FROM $table_name");
}