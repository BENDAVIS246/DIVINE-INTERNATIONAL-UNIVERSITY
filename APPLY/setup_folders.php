<?php
// Array of folders to create
$folders = [
    'uploads',
    'sql'
];

foreach ($folders as $folder) {
    if (!is_dir($folder)) {
        if (mkdir($folder, 0777, true)) {
            echo "Folder '$folder' created successfully.<br>";
        } else {
            echo "Failed to create folder '$folder'. Check permissions.<br>";
        }
    } else {
        echo "Folder '$folder' already exists.<br>";
    }
}

// Set permissions for uploads folder
if (is_dir('uploads')) {
    if (chmod('uploads', 0777)) {
        echo "Permissions set to 0777 for 'uploads' folder.<br>";
    } else {
        echo "Failed to set permissions for 'uploads'.<br>";
    }
}

echo "<br>Setup completed successfully!";
?>
