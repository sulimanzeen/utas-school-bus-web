<?php
// Template/driver_dashboard.php
// Driver dashboard - monitors IoT RFID system in real-time

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Require logged-in driver
if (empty($_SESSION['LoggedIN']) || empty($_SESSION['UserTYPE']) || $_SESSION['UserTYPE'] !== 'driver') {
    header('Location: ../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Driver Dashboard - Smart Bus Tracking</title>
<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
        }

        .navbar {
            background: white;
            padding: 1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.2rem;
            font-weight: 700;
            color: #667eea;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            font-weight: 600;
            color: #333;
            font-size: 0.9rem;
        }

        .user-role {
            font-size: 0.75rem;
            color: #666;
        }

        .logout-btn {
            padding: 0.5rem 1rem;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 1rem;
        }

        .header {
            margin-bottom: 1.5rem;
        }

        .header h1 {
            color: #333;
            margin-bottom: 0.5rem;
            font-size: 1.5rem;
        }

        .header p {
            color: #666;
            font-size: 0.9rem;
        }

        .trip-control {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .trip-status {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        .trip-status.inactive {
            color: #dc3545;
        }

        .trip-status.active {
            color: #28a745;
        }

        .trip-btn {
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: 700;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
            margin: 0.5rem;
            width: calc(100% - 1rem);
        }

        .trip-btn.start {
            background: #28a745;
            color: white;
        }

        .trip-btn.start:hover {
            background: #218838;
        }

        .trip-btn.end {
            background: #dc3545;
            color: white;
        }

        .trip-btn.end:hover {
            background: #c82333;
        }

        .trip-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: white;
            padding: 1rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .stat-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #666;
            font-size: 0.8rem;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
        }

        .card {
            background: white;
            border-radius: 10px;
            padding: 1.25rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #333;
        }

        .student-list {
            max-height: none;
        }

        .student-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.875rem;
            border-bottom: 1px solid #f0f0f0;
            gap: 0.75rem;
            transition: all 0.3s;
        }

        .student-item:hover {
            background: #f8f9ff;
        }

        .student-item.onboard {
            background: #d4edda;
            animation: boardFlash 0.5s ease-in-out;
        }

        .student-item.just-boarded {
            animation: boardFlash 1s ease-in-out;
        }

        .student-item.just-exited {
            animation: exitFlash 1s ease-in-out;
        }

        @keyframes boardFlash {
            0%, 100% { background: #d4edda; }
            50% { background: #28a745; }
        }

        @keyframes exitFlash {
            0%, 100% { background: #f8f9ff; }
            50% { background: #ffc107; }
        }

        .student-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex: 1;
            min-width: 0;
        }

        .student-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            flex-shrink: 0;
            transition: all 0.3s;
        }

        .student-item.onboard .student-avatar {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        }

        .student-details h4 {
            color: #333;
            margin-bottom: 0.25rem;
            font-size: 0.95rem;
        }

        .student-details p {
            color: #666;
            font-size: 0.75rem;
        }

        .status-badge {
            display: inline-block;
            padding: 0.3rem 0.7rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            white-space: nowrap;
            flex-shrink: 0;
            transition: all 0.3s;
        }

        .status-badge.onboard {
            background: #28a745;
            color: white;
        }

        .status-badge.expected {
            background: #6c757d;
            color: white;
        }

        .alert-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-icon {
            font-size: 1.8rem;
            flex-shrink: 0;
        }

        .alert-content h4 {
            color: #856404;
            margin-bottom: 0.25rem;
            font-size: 0.95rem;
        }

        .alert-content p {
            color: #856404;
            font-size: 0.85rem;
        }

        .rfid-monitor {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 15px;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .rfid-monitor h3 {
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }

        .monitor-animation {
            width: 150px;
            height: 150px;
            margin: 1rem auto;
            border: 4px dashed rgba(255,255,255,0.5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            animation: scan 2s infinite;
        }

        @keyframes scan {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.7; }
        }

        .monitor-status {
            font-size: 1rem;
            margin-top: 0.75rem;
        }

        .live-indicator {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255,255,255,0.2);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            margin-top: 1rem;
        }

        .pulse-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #28a745;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.2); }
        }

        .no-data {
            text-align: center;
            padding: 2rem;
            color: #666;
        }

        .last-update {
            text-align: center;
            color: #666;
            font-size: 0.8rem;
            margin-top: 1rem;
        }

        /* Toast notifications */
        .toast-container {
            position: fixed;
            left: 50%;
            transform: translateX(-50%);
            bottom: 24px;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            z-index: 1200;
            align-items: center;
            pointer-events: none;
        }

        .toast {
            background: rgba(0,0,0,0.8);
            color: #fff;
            padding: 0.6rem 1rem;
            border-radius: 8px;
            min-width: 200px;
            max-width: 420px;
            text-align: center;
            box-shadow: 0 6px 18px rgba(0,0,0,0.2);
            opacity: 0;
            transform: translateY(12px) scale(0.98);
            transition: all 220ms cubic-bezier(.2,.9,.2,1);
            pointer-events: auto;
            font-weight: 600;
        }

        .toast.show { opacity: 1; transform: translateY(0) scale(1); }
        .toast.success { background: linear-gradient(90deg,#28a745,#20c997); }
        .toast.info { background: linear-gradient(90deg,#333,#666); }

        @media (min-width: 769px) {
            .navbar {
                padding: 1rem 2rem;
            }

            .logo {
                font-size: 1.5rem;
            }

            .container {
                padding: 2rem;
            }

            .header h1 {
                font-size: 2rem;
            }

            .header p {
                font-size: 1rem;
            }

            .trip-control {
                padding: 2rem;
            }

            .trip-status {
                font-size: 1.5rem;
            }

            .trip-btn {
                padding: 1.2rem 3rem;
                font-size: 1.2rem;
                width: auto;
            }

            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 1.5rem;
                margin-bottom: 2rem;
            }

            .stat-card {
                padding: 1.5rem;
            }

            .stat-icon {
                font-size: 2.5rem;
            }

            .stat-value {
                font-size: 2rem;
            }

            .card {
                padding: 1.5rem;
            }

            .card-title {
                font-size: 1.3rem;
            }

            .student-avatar {
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
            }

            .student-details h4 {
                font-size: 1rem;
            }

            .student-details p {
                font-size: 0.85rem;
            }

            .status-badge {
                padding: 0.4rem 1rem;
                font-size: 0.85rem;
            }

            .rfid-monitor {
                padding: 2rem;
            }

            .rfid-monitor h3 {
                font-size: 1.5rem;
            }

            .monitor-animation {
                width: 200px;
                height: 200px;
                font-size: 4rem;
            }

            .monitor-status {
                font-size: 1.1rem;
            }

            .student-list {
                max-height: 400px;
                overflow-y: auto;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .trip-btn {
                font-size: 1rem;
                padding: 0.875rem 1.5rem;
            }
        }
    </style>
    <script>
    // Load loader CSS/JS robustly (tries Template/ then root), and provide safe stubs
    (function(){
        function addCSS(path, fallback){
            var l = document.createElement('link'); l.rel = 'stylesheet'; l.href = path;
            l.onerror = function(){ if(fallback) addCSS(fallback); };
            document.head.appendChild(l);
        }
        function addJS(path, fallback, cb){
            var s = document.createElement('script'); s.src = path; s.async = false;
            s.onload = function(){ if(cb) cb(); };
            s.onerror = function(){ if(fallback) addJS(fallback, null, cb); else if(cb) cb(); };
            document.head.appendChild(s);
        }

        // ensure functions exist so early calls don't throw
        window.showLoader = window.showLoader || function(){};
        window.hideLoader = window.hideLoader || function(){};
        window.setLoaderProgress = window.setLoaderProgress || function(){};

        addCSS('Template/loader.css', 'loader.css');
        addJS('Template/loader.js', 'loader.js');
    })();
    </script>
</head>
<body>
    <!-- Loader overlay (positioned fixed; won't affect layout) -->
    <div id="page-loader" class="page-loader" style="display:flex; align-items:center; justify-content:center;">
        <div class="loader-card">
            <div class="loader-brand">🚌</div>
            <div class="loader-info">
                <div class="loader-title">Driver Dashboard</div>
                <div class="loader-sub">Loading dashboard…</div>
            </div>
            <div class="spinner" aria-hidden="true"></div>
        </div>
    </div>
    <!-- Toast container (for trip start/end notifications) -->
    <div id="toast-container" class="toast-container" aria-live="polite" aria-atomic="true"></div>
<nav class="navbar">
    <div class="logo"><span>🚌</span><span>Smart Bus</span></div>
    <div class="user-menu">
        <div class="user-info">
            <div class="user-name" id="driverName">Driver</div>
            <div class="user-role" id="busInfo">Loading...</div>
        </div>
        <button class="logout-btn" onclick="logout()">Logout</button>
    </div>
</nav>

<div class="container">
    <div class="header">
        <h1 id="welcomeMessage">Welcome, Driver!</h1>
        <p>Monitor your bus in real-time via IoT RFID system</p>
    </div>

    <div id="noBusAlert" style="display: none;" class="card">
        <p><strong>No bus assigned.</strong> Please contact admin to assign a bus.</p>
    </div>

    <div id="dashboardContent" style="display: none;">
        <div class="alert-box" id="capacityAlert" style="display: none;">
            <div class="alert-icon">⚠️</div>
            <div class="alert-content">
                <h4>Capacity Warning</h4>
                <p id="capacityText">Bus approaching max capacity</p>
            </div>
        </div>

        <div class="trip-control">
            <div id="tripStatus" class="trip-status inactive">Trip Not Started</div>
            <p style="color: #666; margin-bottom: 1rem; font-size: 0.9rem;">Start your trip to enable IoT RFID tracking</p>
            <button class="trip-btn start" id="startTripBtn" onclick="startTrip()">🚀 Start Trip</button>
            <button class="trip-btn end" id="endTripBtn" onclick="endTrip()" style="display: none;">🛑 End Trip</button>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">👨‍🎓</div>
                <div class="stat-label">Onboard Now</div>
                <div class="stat-value" id="studentsOnboard">0</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">📍</div>
                <div class="stat-label">Capacity</div>
                <div class="stat-value" id="busCapacity">0</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">✅</div>
                <div class="stat-label">Check-ins Today</div>
                <div class="stat-value" id="checkinsToday">0</div>
            </div>
            
        </div>

        <div class="rfid-monitor" id="rfidMonitor" style="display: none;">
            <h3>🔴 LIVE IoT RFID Monitoring</h3>
            <div class="monitor-animation">📡</div>
            <div class="monitor-status">Monitoring RFID scans...</div>
            <div class="live-indicator">
                <div class="pulse-dot"></div>
                <span>System Active</span>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Student List - Real-Time Status</h2>
                <span style="color: #666; font-size: 0.85rem;" id="busNumber">Bus #-</span>
            </div>
            <div class="student-list" id="studentList">
                <div class="no-data">Loading students...</div>
            </div>
            <div class="last-update" id="lastUpdate">Last updated: --</div>
        </div>
    </div>
</div>

<script>
const API_DASHBOARD = 'api/get_driver_dashboard.php';
const API_SET_TRIP = 'api/set_trip_status.php';

let dashboardData = null;
let previousStudentStates = {}; // Track previous states for animation
let tripActive = false;
let tripStartTime;
let tripTimer;
let autoRefreshInterval;

function escapeHtml(s) {
    if (s === null || s === undefined) return '';
    return String(s).replace(/[&<>"']/g, (m) => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]));
}

async function fetchJSON(url, opts = {}) {
    const res = await fetch(url, opts);
    if (!res.ok) throw new Error('HTTP ' + res.status);
    return await res.json();
}

// Toast helper
function showToast(message, type = 'info', ttl = 4000){
    try{
        const container = document.getElementById('toast-container') || (function(){
            const c = document.createElement('div'); c.id = 'toast-container'; c.className='toast-container'; document.body.appendChild(c); return c;
        })();

        const t = document.createElement('div');
        t.className = 'toast ' + (type || 'info');
        t.textContent = message;
        container.appendChild(t);
        // trigger animation
        requestAnimationFrame(()=> t.classList.add('show'));
        setTimeout(()=>{ t.classList.remove('show'); setTimeout(()=>{ t.remove(); }, 220); }, ttl);
    }catch(e){ console.error('showToast error', e); }
}

function logout() {
    if (tripActive) {
        if (!confirm('Trip is active. Are you sure you want to logout? This will NOT end the trip.')) {
            return;
        }
    }
    window.location.href = 'api/logout.php';
}

async function loadDashboard() {
    try {
        const data = await fetchJSON(API_DASHBOARD);
        dashboardData = data;
        
        if (!data.bus_id) {
            document.getElementById('noBusAlert').style.display = 'block';
            document.getElementById('dashboardContent').style.display = 'none';
            return;
        }
        
        document.getElementById('noBusAlert').style.display = 'none';
        document.getElementById('dashboardContent').style.display = 'block';
        
        // Update header
        document.getElementById('driverName').textContent = data.username;
        document.getElementById('busInfo').textContent = 'Bus #' + data.bus_id;
        document.getElementById('welcomeMessage').textContent = 'Welcome, ' + data.username + '!';
        document.getElementById('busNumber').textContent = 'Bus #' + data.bus_id;
        
        // Update trip status and notify on changes
        const _prevTripActive = tripActive;
        tripActive = data.trip_status === 1;
        if (_prevTripActive !== tripActive) {
            showToast(tripActive ? 'Trip started' : 'Trip ended', tripActive ? 'success' : 'info');
        }
        updateTripUI();
        
        // Update stats
        document.getElementById('studentsOnboard').textContent = data.students_onboard_count;
        document.getElementById('busCapacity').textContent = data.bus.bus_capacity;
        document.getElementById('checkinsToday').textContent = data.checkins_today;
        
        // Check capacity warning
        if (data.students_onboard_count >= (data.bus.bus_capacity - 2)) {
            document.getElementById('capacityAlert').style.display = 'flex';
            document.getElementById('capacityText').textContent = 
                `Bus approaching max (${data.students_onboard_count}/${data.bus.bus_capacity})`;
        } else {
            document.getElementById('capacityAlert').style.display = 'none';
        }
        
        // Render students with animation detection
        renderStudents(data.students);
        
        // Update last update time
        const now = new Date();
        document.getElementById('lastUpdate').textContent = 
            'Last updated: ' + now.toLocaleTimeString();
        
    } catch (e) {
        console.error('loadDashboard error', e);
        alert('Failed to load dashboard data');
    }
}

function renderStudents(students) {
    const container = document.getElementById('studentList');
    
    if (!students || students.length === 0) {
        container.innerHTML = '<div class="no-data">No students assigned to this bus</div>';
        return;
    }
    
    container.innerHTML = '';
    
    students.forEach(student => {
        const isOnboard = student.is_onboard;
        const initial = student.student_name.charAt(0).toUpperCase();
        const studentId = student.student_id;
        
        // Detect state change for animation
        const prevState = previousStudentStates[studentId];
        let animationClass = '';
        
        if (prevState !== undefined && prevState !== isOnboard) {
            if (isOnboard) {
                animationClass = 'just-boarded';
                // Play sound or show notification if desired
                console.log(`🚌 ${student.student_name} just BOARDED!`);
            } else {
                animationClass = 'just-exited';
                console.log(`🚪 ${student.student_name} just EXITED!`);
            }
        }
        
        // Update previous state
        previousStudentStates[studentId] = isOnboard;
        
        const item = document.createElement('div');
        item.className = `student-item ${isOnboard ? 'onboard' : ''} ${animationClass}`;
        item.dataset.studentId = studentId;
        
        item.innerHTML = `
            <div class="student-info">
                <div class="student-avatar">${escapeHtml(initial)}</div>
                <div class="student-details">
                    <h4>${escapeHtml(student.student_name)}</h4>
                    <p>RFID: ${escapeHtml(student.student_rfid)}</p>
                </div>
            </div>
            <span class="status-badge ${isOnboard ? 'onboard' : 'expected'}">
                ${isOnboard ? '✓ Onboard' : 'Expected'}
            </span>
        `;
        
        // Remove animation class after animation completes
        if (animationClass) {
            setTimeout(() => {
                item.classList.remove('just-boarded', 'just-exited');
            }, 1000);
        }
        
        container.appendChild(item);
    });
}

function updateTripUI() {
    const statusEl = document.getElementById('tripStatus');
    const startBtn = document.getElementById('startTripBtn');
    const endBtn = document.getElementById('endTripBtn');
    const monitor = document.getElementById('rfidMonitor');
    
    if (tripActive) {
        statusEl.textContent = '🟢 Trip Active';
        statusEl.className = 'trip-status active';
        startBtn.style.display = 'none';
        endBtn.style.display = 'inline-block';
        monitor.style.display = 'block';
        
        if (!tripTimer) {
            tripStartTime = new Date();
            tripTimer = setInterval(updateTripDuration, 1000);
        }
        
        // Start auto-refresh every 3 seconds when trip is active
        if (!autoRefreshInterval) {
            autoRefreshInterval = setInterval(() => {
                loadDashboard();
            }, 3000);
        }
    } else {
        statusEl.textContent = '🔴 Trip Not Started';
        statusEl.className = 'trip-status inactive';
        startBtn.style.display = 'inline-block';
        endBtn.style.display = 'none';
        monitor.style.display = 'none';
        
        if (tripTimer) {
            clearInterval(tripTimer);
            tripTimer = null;
        }
        
        // Slow down refresh when trip is not active
        if (autoRefreshInterval) {
            clearInterval(autoRefreshInterval);
            autoRefreshInterval = null;
        }
        
      
    }
}

function updateTripDuration() {
    const now = new Date();
    const duration = Math.floor((now - tripStartTime) / 1000);
    const minutes = Math.floor(duration / 60);
    const seconds = duration % 60;
   
}



async function startTrip() {
    if (tripActive) return;
    
    try {
        const data = await fetchJSON(API_SET_TRIP, {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ status: 1 })
        });
        
        if (data.status === 1) {
            tripActive = true;
            updateTripUI();
            showToast('Trip started', 'success');
        } else {
            alert('Failed to start trip: ' + (data.error || 'Unknown error'));
        }
    } catch (err) {
        console.error('startTrip error', err);
        alert('Server error when starting trip');
    }
}

async function endTrip() {
    if (!tripActive) return;
    
    const onboardCount = dashboardData ? dashboardData.students_onboard_count : 0;
    
    if (onboardCount > 0) {
        if (!confirm(`Warning: ${onboardCount} student(s) still onboard. Ending the trip will automatically mark them as exited. Continue?`)) {
            return;
        }
    }
    
    try {
        const data = await fetchJSON(API_SET_TRIP, {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ status: 0 })
        });
        
        if (data.status === 1) {
            tripActive = false;
            updateTripUI();
            loadDashboard(); // Reload to show updated student list
            showToast('Trip ended', 'info');
        } else {
            alert('Failed to end trip: ' + (data.error || 'Unknown error'));
        }
    } catch (err) {
        console.error('endTrip error', err);
        alert('Server error when ending trip');
    }
}

// Load dashboard on page load
function _waitForLoader(timeout = 2000){
    if(window.showLoader) return Promise.resolve();
    return new Promise(res => {
        const t = setInterval(()=>{ if(window.showLoader){ clearInterval(t); res(); } }, 50);
        setTimeout(()=>{ clearInterval(t); res(); }, timeout);
    });
}

window.onload = async function() {
    await _waitForLoader();
    try{
        if (window.showLoader) showLoader('Loading driver dashboard...');
        await loadDashboard();
    }catch(e){
        console.error('initial load error', e);
    }finally{
        if (window.hideLoader) hideLoader();
    }

    // Auto-refresh every 10 seconds when trip is NOT active
    // When trip IS active, refresh every 3 seconds (set in updateTripUI)
    setInterval(() => {
        if (!tripActive) {
            loadDashboard();
        }
    }, 10000);
};
</script>
</body>
</html>