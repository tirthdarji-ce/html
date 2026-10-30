<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require 'php/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html?status=unauthorized");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management | Admin</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f6f9; margin: 0; }
        header { background-color: #0d6efd; padding: 15px 30px; display: flex; justify-content: space-between; color: white; }
        header a { color: white; text-decoration: none; font-weight: bold; margin-left: 15px; }
        .content-section { max-width: 1000px; margin: 40px auto; background: white; padding: 20px; border-radius: 8px; }
        .btn { background: #0d6efd; color: white; padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none;}
        table { width: 100%; border-collapse: collapse; margin-top: 20px;}
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #0d6efd; color: white; }
    </style>
</head>
<body>
    <header>
        <div><strong>StudentHub Admin</strong></div>
        <nav>
            <a href="admin_students.php">Manage Students</a>
            <a href="admin_events.php" style="color: #ffc107;">Manage Events</a>
            <a href="logout.php" style="color: #dc3545;">Logout</a>
        </nav>
    </header>
    <main class="content-section">
        <h2>Manage Campus Events</h2>
        
        <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] == 'added'): ?>
                <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px;">Event created successfully.</div>
            <?php elseif ($_GET['status'] == 'deleted'): ?>
                <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px;">Event deleted successfully.</div>
            <?php elseif ($_GET['status'] == 'error' && isset($_GET['msg'])): ?>
                <div style="background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px;">Error: <?php echo htmlspecialchars($_GET['msg']); ?></div>
            <?php endif; ?>
        <?php endif; ?>

        <div style="background: #f8f9fa; padding: 20px; border: 1px solid #ddd; margin-bottom: 20px;">
            <h3>Add New Event</h3>
            <form action="process_event.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="title" placeholder="Event Title" required style="padding: 8px; margin-right: 10px;">
                <select name="category" required style="padding: 8px; margin-right: 10px;">
                    <option value="">Select Category</option>
                    <option value="Technology">Technology</option>
                    <option value="Sports">Sports</option>
                    <option value="Cultural">Cultural</option>
                </select>
                <input type="date" name="event_date" required style="padding: 8px; margin-right: 10px;">
                <input type="file" name="poster" accept="image/jpeg, image/png" required style="margin-bottom: 15px;">
                <br>
                <textarea name="description" rows="3" placeholder="Event Description" style="width: 100%; margin-bottom: 10px; padding: 8px;" required></textarea>
                <button type="submit" class="btn">Create Event</button>
            </form>
        </div>

        <h3>Existing Events</h3>
        
        <!-- Live Search Input Box -->
        <div style="margin-bottom: 15px;">
            <input type="text" id="searchBox" placeholder="Search events by title or category..." onkeyup="filterEvents()" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
        </div>

        <table>
            <thead>
                <tr>
                    <th>Poster</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="eventTableBody">
                <tr><td colspan="5" style="text-align: center;">Loading events asynchronously...</td></tr>
            </tbody>
        </table>
    </main>

    <!-- Practical 13: Fetch API & Live Search Script -->
    <script>
    let allEvents = []; // Badha events store karva mate global array

    document.addEventListener("DOMContentLoaded", function() {
        loadEventsAsync();
    });

    function loadEventsAsync() {
        fetch('api_events.php')
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    allEvents = result.data; // Data save kari didho
                    displayEvents(allEvents);
                } else {
                    document.getElementById('eventTableBody').innerHTML = `<tr><td colspan="5" style="text-align: center;">No events created yet.</td></tr>`;
                }
            })
            .catch(error => {
                console.error('Error fetching events:', error);
                document.getElementById('eventTableBody').innerHTML = `<tr><td colspan="5" style="text-align: center; color: red;">Failed to load events.</td></tr>`;
            });
    }

    function displayEvents(events) {
        const tbody = document.getElementById('eventTableBody');
        tbody.innerHTML = '';
        
        if (events.length > 0) {
            events.forEach(event => {
                let tr = document.createElement('tr');
                tr.innerHTML = `
                    <td><img src="posters/${event.poster_image}" alt="Poster" width="60" style="border-radius: 4px;"></td>
                    <td>${event.title}</td>
                    <td>${event.category}</td>
                    <td>${event.event_date}</td>
                    <td>
                        <a href="delete_event.php?id=${event.id}" class="btn" style="background: #dc3545;" onclick="return confirm('Are you sure you want to delete this event?');">Delete</a>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        } else {
            tbody.innerHTML = `<tr><td colspan="5" style="text-align: center;">No matching events found.</td></tr>`;
        }
    }

    // Live search function je type karta j filter karse
    function filterEvents() {
        const query = document.getElementById('searchBox').value.toLowerCase();
        const filteredEvents = allEvents.filter(event => {
            return event.title.toLowerCase().includes(query) || event.category.toLowerCase().includes(query);
        });
        displayEvents(filteredEvents);
    }
    </script>
</body>
</html>
