<?php
// Session start karo jethi te mali sake
session_start();

// Badha session variables clear karo
session_unset();

// Session ne completely destroy karo
session_destroy();

// User ne login page par pacho moklo, sathe logged_out no message

header("Location: ../login.html?status=logged_out");
exit();