<?php

function setTemporarySession($category = 'csrf', $key = 'error', $value = 'csrf problem') {
    $_SESSION[$category][$key] = $value;
}

function showTemporaryMessage($category, $key) {
    if (isset($_SESSION[$category][$key])&& $key === 'success') {
        echo '<div class="mb-4 p-3 bg-green-100 text-green-800 rounded border border-green-300 text-sm">';
        echo 'نوع پیام: ' . htmlspecialchars($key) . '<br>';
        echo 'متن پیام: ' . htmlspecialchars($_SESSION[$category][$key]);
        echo '</div>';

        unset($_SESSION[$category][$key]); // Only unset the specific message
        if (empty($_SESSION[$category])) {
            unset($_SESSION[$category]); // Clean up if empty
        }

    } elseif (isset($_SESSIONp[$category][$key]) && $key === 'error') {
       echo '<div class="mb-4 p-3 bg-red-100 text-red-800 rounded border border-red-300 text-sm">';
        echo 'نوع پیام: ' . htmlspecialchars($key) . '<br>';
        echo 'متن پیام: ' . htmlspecialchars($_SESSION[$category][$key]);
        echo '</div>';

        unset($_SESSION[$category][$key]); // Only unset the specific message
        if (empty($_SESSION[$category])) {
            unset($_SESSION[$category]); // Clean up if empty
        }
    }
}

function successMessage() {
    if (isset($_SESSION['success'])) {
        if (is_array($_SESSION['success'])) {
            error_log('Warning: success message should be string, array given');
            $message = 'Operation completed';
        } else {
            $message = (string)$_SESSION['success'];
        }
        
        echo '<div class="mb-4 p-3 bg-green-100 text-green-800 rounded border border-green-300 text-sm">';
        echo 'متن پیام: ' . htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
        echo '</div>';
        unset($_SESSION['success']);
    }
}


function errorMessage() {
    if (isset($_SESSION['error'])) {
        if (is_array($_SESSION['error'])) {
            error_log('Warning: success message should be string, array given');
            $message = 'Operation completed';
        } else {
            $message = (string)$_SESSION['error'];
        }
        
        echo '<div class="mb-4 p-3 bg-red-100 text-red-800 rounded border border-red-300 text-sm">';
        echo 'متن پیام: ' . htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
        echo '</div>';
        unset($_SESSION['error']);
    }
}
?>
