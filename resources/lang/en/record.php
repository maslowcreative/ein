<?php

return [

    'success' => [
        'added' => 'Record has been added successfully.',
        'updated' => 'Record has been updated successfully.',
        'retrieved' => 'Record has been retrieved successfully.',
        'deleted' => 'Record has been deleted successfully.',
        'registered' => 'User has been successfully registered.',
        'listing_posted_on_platform' => 'The listing has been successfully posted on :platform.',
        'listing_edited_on_platform' => 'The listing has been successfully updated on :platform.',
        'package_applied_platform' => 'Package :package_type has been successfully applied.',
        'listing_deleted_platform' => 'Listing has been successfully deleted from :platform.',
        'listing_enabled_platform' => 'Listing has been successfully enabled on :platform.',
        'listing_disabled_platform' => 'Listing has been successfully disabled on :platform.',
        'sms_sent' => 'SMS have been sent successfully.',
    ],

    'fail' => [
        'added' => 'Record could not be added.',
        'updated' => 'Record could not be updated.',
        'retrieved' => 'Record could not be retrieved.',
        'deleted' => 'Record could not be deleted.',
        'no_platform_user' => 'This user does not have any :platform user linked with it.',
        'no_platform_listing' => 'This listing is not posted on :platform.',
        'no_platform_location' => 'The location of this property is not linked with any location on :platform.',
        'listing_already_posted_on_platform' => 'This listing has already been posted on :platform.',
        'listing_posted_failed_on_platform' => 'This listing could not be posted on :platform.',
        'listing_edited_failed_on_platform' => 'The listing could not be updated on :platform.',
        'listing_deleted_status_on_platform' => 'The listing is deleted on :platform. It can not be processed.',
        'platform_fail' => 'Failed to retrieve data from :platform',
        'platform_image_fail' => 'Failed to upload image to :platform',
        'no_platform_package' => 'No active package found for :platform.',
        'package_not_applied_platform' => 'Package :package_type could not be applied.',
        'listing_delete_platform' => 'Listing is already deleted from :platform.',
        'listing_enable_platform' => 'Listing is already enabled on :platform.',
        'listing_disable_platform' => 'Listing is already disabled on :platform.',
        'sms_sent_fail' => 'SMS sending failed.',
    ],
];
