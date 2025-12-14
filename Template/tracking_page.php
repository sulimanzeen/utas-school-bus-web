<?php
// Template/tracking_page.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['LoggedIN']) || empty($_SESSION['UserTYPE'])) {
    header('Location: ../index.php');
    exit;
}

$username  = $_SESSION['LoggedIN'];
$user_type = $_SESSION['UserTYPE'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bus Tracking - Smart Bus System</title>

<style>
* { margin:0; padding:0; box-sizing:border-box; }

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background:#f5f7fa;
}

/* NAVBAR */
.navbar {
    background:white;
    padding:1rem 2rem;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}

.logo {
    font-size:1.4rem;
    font-weight:700;
    color:#667eea;
}

.user-info {
    text-align:right;
}

.user-name {
    font-size:.9rem;
    font-weight:600;
}

.user-role {
    font-size:.75rem;
    color:#666;
    text-transform:capitalize;
}

.back-btn {
    margin-left:1rem;
    padding:.5rem 1rem;
    background:#667eea;
    color:white;
    border-radius:6px;
    text-decoration:none;
}

/* PAGE */
.container {
    max-width:1200px;
    margin:1.5rem auto;
    padding:0 1rem;
}

.header {
    text-align:center;
    margin-bottom:1.5rem;
}

.header h1 {
    font-size:1.8rem;
    color:#333;
}

/* Bus card styles */
.bus-card {
    background:white;
    border-radius:10px;
    padding:1.2rem;
    margin-bottom:1rem;
    box-shadow:0 2px 10px rgba(0,0,0,.05);
}

.bus-header {
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.bus-title {
    font-size:1.1rem;
    font-weight:700;
}

.badge {
    padding:.3rem .8rem;
    border-radius:20px;
    font-size:.8rem;
    font-weight:600;
}

.badge.active {
    background:#d4edda;
    color:#155724;
}

.badge.inactive {
    background:#f8d7da;
    color:#721c24;
}

.bus-info {
    margin-top:.4rem;
    font-size:.9rem;
    color:#444;
}

.map-link {
    display:inline-block;
    margin-top:.8rem;
    padding:.5rem 1rem;
    background:#667eea;
    color:white;
    text-decoration:none;
    border-radius:6px;
    font-size:.9rem;
}

.map-link.disabled {
    background:#aaa;
    pointer-events:none;
}

/* ERROR */
.error-message {
    background:#f8d7da;
    color:#721c24;
    padding:1rem;
    border-radius:8px;
    margin-bottom:1rem;
    text-align:center;
}
</style>
</head>

<body>

    <!-- Page loader overlay -->
    <div id="page-loader" class="page-loader">
        <div class="loader-card">
            <div class="loader-brand">📍</div>
            <div class="loader-info">
                <div class="loader-title">Tracking Page</div>
                <div class="loader-sub">Fetching live locations…</div>
            </div>
            <div class="spinner" aria-hidden="true"></div>
        </div>
    </div>

    <link rel="stylesheet" href="loader.css">

<nav class="navbar">
    <div class="logo">🚌 Bus Tracking</div>
    <div style="display:flex; align-items:center;">
        <a href="../Dashboard.php" class="back-btn">← Back to Dashboard</a>
    </div>
</nav>

<div class="container">
    <div class="header">
        <h1>Live Bus Locations</h1>
        <p>Tap a bus to open its location in Google Maps</p>
    </div>

    <div id="errorMessage" class="error-message" style="display:none;"></div>
    <div id="busList"></div>
</div>

<script src="loader.js"></script>
<script>
const API_URL = '../api/get_bus_location.php';

function escapeHtml(text) {
    return text ? text.replace(/[&<>"']/g, m => ({
        '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'
    })[m]) : '';
}

async function loadBuses() {
    try {
        const res = await fetch(API_URL);
        const data = await res.json();

        if (data.status !== 1) {
            throw new Error(data.error || 'Failed to load buses');
        }

        const container = document.getElementById('busList');
        container.innerHTML = '';

        if (data.buses.length === 0) {
            container.innerHTML = '<p style="text-align:center;">No buses available</p>';
            return;
        }

        data.buses.forEach(bus => {
            const statusClass = bus.trip_status === 1 ? 'active' : 'inactive';
            const statusText  = bus.trip_status === 1 ? 'Active' : 'Inactive';

            const mapLink = bus.google_map_url
                ? `<a class="map-link" target="_blank" href="${bus.google_map_url}">Open in Google Maps</a>`
                : `<span class="map-link disabled">Location Not Set</span>`;

            container.innerHTML += `
                <div class="bus-card">
                    <div class="bus-header">
                        <div class="bus-title">🚌 Bus #${bus.bus_id} - ${escapeHtml(bus.bus_model)}</div>
                        <span class="badge ${statusClass}">${statusText}</span>
                    </div>
                    <div class="bus-info">Driver: ${escapeHtml(bus.bus_driver_name)}</div>
                    <div class="bus-info">Students: ${bus.total_students} / ${bus.bus_capacity}</div>
                    ${mapLink}
                </div>
            `;
        });

    } catch (err) {
        const errorBox = document.getElementById('errorMessage');
        errorBox.textContent = err.message;
        errorBox.style.display = 'block';
    }
}

// show loader while first fetch completes
(async function(){
    try{
        showLoader('Loading live bus locations...');
        await loadBuses();
    }catch(e){
        console.error('initial load error', e);
    }finally{
        hideLoader();
    }

    setInterval(loadBuses, 10000);
})();
</script>

</body>
</html>
