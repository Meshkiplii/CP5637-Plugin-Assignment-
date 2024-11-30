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