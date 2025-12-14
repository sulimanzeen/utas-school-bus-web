<?php
// IMPORTANT: this file is included from Dashboard.php
// DO NOT call session_start() here to avoid "session already started" notice.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Admin Dashboard - Smart Bus Tracking</title>
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
            display: flex;
            flex-direction: column;
        }

        .sidebar {
            width: 100%;
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            color: white;
            position: fixed;
            bottom: 0;
            left: 0;
            z-index: 100;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.2);
        }

        .sidebar-header {
            display: none;
        }

        .sidebar-menu {
            display: flex;
            justify-content: space-around;
            padding: 0.5rem;
            overflow-x: auto;
        }

        .menu-item {
            padding: 0.75rem 0.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.25rem;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            color: white;
            min-width: 60px;
            border-radius: 8px;
        }

        .menu-item:hover, .menu-item.active {
            background: rgba(255,255,255,0.2);
        }

        .menu-icon {
            font-size: 1.3rem;
        }

        .menu-text {
            font-size: 0.7rem;
            white-space: nowrap;
        }

        .main-content {
            flex: 1;
            width: 100%;
            margin-bottom: 70px;
        }

        .navbar {
            background: white;
            padding: 1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: flex-end;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 99;
        }

        .search-bar {
            display: none;
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

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .stat-icon {
            font-size: 1.8rem;
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

        .stat-change {
            font-size: 0.75rem;
            color: #28a745;
            margin-top: 0.5rem;
        }

        .card {
            background: white;
            border-radius: 10px;
            padding: 1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #333;
        }

        .table-container {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }

        th {
            background: #f8f9ff;
            padding: 0.75rem 0.5rem;
            text-align: left;
            font-weight: 600;
            color: #667eea;
            border-bottom: 2px solid #e0e0e0;
            font-size: 0.85rem;
        }

        td {
            padding: 0.75rem 0.5rem;
            border-bottom: 1px solid #f0f0f0;
            font-size: 0.85rem;
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.6rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .status-badge.active {
            background: #d4edda;
            color: #155724;
        }

        .status-badge.inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .status-badge.warning {
            background: #fff3cd;
            color: #856404;
        }

        .action-btns {
            display: flex;
            gap: 0.25rem;
        }

        .icon-btn {
            padding: 0.4rem 0.6rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .icon-btn.edit {
            background: #e3f2fd;
            color: #1976d2;
        }

        .icon-btn.delete {
            background: #ffebee;
            color: #c62828;
        }

        .icon-btn.view {
            background: #f3e5f5;
            color: #7b1fa2;
        }

        @media (min-width: 769px) {
            body {
                flex-direction: row;
            }

            .sidebar {
                width: 260px;
                min-height: 100vh;
                position: fixed;
                left: 0;
                top: 0;
                bottom: auto;
                box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            }

            .sidebar-header {
                display: block;
                padding: 1.5rem;
                border-bottom: 1px solid rgba(255,255,255,0.1);
            }

            .logo {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                font-size: 1.3rem;
                font-weight: 700;
            }

            .sidebar-menu {
                flex-direction: column;
                padding: 1rem 0;
            }

            .menu-item {
                flex-direction: row;
                padding: 1rem 1.5rem;
                gap: 1rem;
                min-width: auto;
            }

            .menu-item:hover, .menu-item.active {
                background: rgba(255,255,255,0.1);
                border-left: 4px solid white;
            }

            .menu-text {
                font-size: 1rem;
            }

            .main-content {
                margin-left: 260px;
                margin-bottom: 0;
                width: calc(100% - 260px);
            }

            .navbar {
                padding: 1rem 2rem;
            }

            .search-bar {
                display: flex;
                align-items: center;
                background: #f5f7fa;
                padding: 0.5rem 1rem;
                border-radius: 8px;
                gap: 0.5rem;
                width: 300px;
            }

            .search-bar input {
                border: none;
                background: none;
                outline: none;
                width: 100%;
            }

            .container {
                padding: 2rem;
            }

            .header h1 {
                font-size: 2rem;
            }

            .stats-grid {
                grid-template-columns: repeat(4, 1fr);
                gap: 1.5rem;
                margin-bottom: 2rem;
            }

            .stat-card {
                padding: 1.5rem;
            }

            .stat-icon {
                font-size: 2rem;
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

            th, td {
                padding: 1rem;
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .menu-text {
                font-size: 0.65rem;
            }
        }
    </style>
</head>
<body>
    <!-- Page loader overlay -->
    <div id="page-loader" class="page-loader">
        <div class="loader-card">
            <div class="loader-brand">🚌</div>
            <div class="loader-info">
                <div class="loader-title">Smart Bus Dashboard</div>
                <div class="loader-sub">Loading data — connecting to server…</div>
            </div>
            <div class="spinner" aria-hidden="true"></div>
        </div>
    </div>

    <link rel="stylesheet" href="Template/loader.css">
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <span>🚌</span>
                <span>Bus Tracking</span>
            </div>
        </div>
        <div class="sidebar-menu">
            <a href="#" id="menu-dashboard" class="menu-item active" onclick="showSection('dashboard')">
                <span class="menu-icon">📊</span>
                <span class="menu-text">Dashboard</span>
            </a>
            <a href="Template/bus_management.php" id="menu-buses" class="menu-item">
                <span class="menu-icon">🚌</span>
                <span class="menu-text">Buses</span>
            </a>
            <a href="Template/student_management.php" id="menu-students" class="menu-item" onclick="showSection('students')">
                <span class="menu-icon">👨‍🎓</span>
                <span class="menu-text">Students</span>
            </a>
            <a href="Template/tracking_page.php" id="menu-tracking" class="menu-item" onclick="showSection('tracking')">
                <span class="menu-icon">📍</span>
                <span class="menu-text">Tracking</span>
            </a>
        </div>
    </div>

    <div class="main-content">
        <nav class="navbar">
            
            <div class="user-menu">
                <div class="user-info">
                    <div class="user-name">Admin</div>
                    <div class="user-role">Administrator</div>
                </div>
                <button class="logout-btn" onclick="logout()">Logout</button>
            </div>
        </nav>

        <div class="container">
            <div id="dashboard-section">
                <div class="header">
                    <h1>Dashboard</h1>
                    <p>System monitoring and management</p>
                </div>

                <div class="stats-grid" id="statsGrid">
                    <!-- dynamic stats will be inserted here -->
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Active Buses</h2>
                    </div>
                    <div class="table-container">
                        <table id="busesTable">
                            <thead>
                                <tr>
                                    <th>Bus</th>
                                    <th>Driver</th>
                                    <th>Load</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- dynamic rows -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Recent Activity</h2>
                        
                    </div>
                    <div class="table-container">
                        <table id="alertsTable">
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>Type</th>
                                    <th>Bus</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- dynamic alerts -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="Template/loader.js"></script>
    <script>
        function showSection(section) {
            const ids = ['dashboard', 'buses', 'students', 'tracking', 'reports', 'settings'];
            ids.forEach(id => {
                const sec = document.getElementById(id + '-section');
                if (sec) sec.style.display = (id === section) ? 'block' : 'none';
            });

            document.querySelectorAll('.menu-item').forEach(mi => mi.classList.remove('active'));
            const activeMenu = document.getElementById('menu-' + section);
            if (activeMenu) activeMenu.classList.add('active');
        }

        function logout() {
            window.location.href = "api/logout.php";
        }

        function escapeHtml(s) {
            if (s === null || s === undefined) return '';
            return String(s).replace(/[&<>"']/g, (m) => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]));
        }

        async function fetchJSON(url, opts = {}) {
            const res = await fetch(url, opts);
            if (!res.ok) throw new Error('HTTP ' + res.status);
            return await res.json();
        }

        async function loadStats() {
            try {
                const data = await fetchJSON('api/get_stats.php');
                const grid = document.getElementById('statsGrid');
                grid.innerHTML = `
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon">🚌</div>
                        </div>
                        <div class="stat-label">Total Buses</div>
                        <div class="stat-value">${data.total_buses ?? 0}</div>
                        <div class="stat-change">↑ ${data.total_buses ?? 0} Active</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon">👨‍🎓</div>
                        </div>
                        <div class="stat-label">Total Students</div>
                        <div class="stat-value">${data.total_students ?? 0}</div>
                        <div class="stat-change">↑ ${data.students_today ?? 0} Today</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon">🚗</div>
                        </div>
                        <div class="stat-label">Active Drivers</div>
                        <div class="stat-value">${data.total_drivers ?? 0}</div>
                        <div class="stat-change">↑ 100%</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon">⚠️</div>
                        </div>
                        <div class="stat-label">Students On Bus</div>
                        <div class="stat-value">${data.alerts_today ?? 0}</div>
                        <div class="stat-change" style="color: #dc3545;">⚠️ Currently Tracked</div>
                    </div>
                `;
            } catch (e) {
                console.error('loadStats error', e);
            }
        }

        async function loadBuses() {
            try {
                const data = await fetchJSON('api/get_buses.php');
                const tbody = document.querySelector('#busesTable tbody');
                tbody.innerHTML = '';
                
                if (data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="4" style="text-align:center; padding:2rem; color:#666;">No buses found</td></tr>';
                    return;
                }
                
                data.forEach(b => {
                    const load = (b.current_load ?? 0) + '/' + (b.bus_capacity ?? 0);
                    const statusClass = b.status_class ?? 'inactive';
                    const statusText = b.status_text ?? 'Idle';
                    
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${escapeHtml(b.bus_name)}</td>
                        <td>${escapeHtml(b.bus_driver_name)}</td>
                        <td>${escapeHtml(load)}</td>
                        <td><span class="status-badge ${statusClass}">${statusText}</span></td>
                    `;
                    tbody.appendChild(tr);
                });
            } catch (e) {
                console.error('loadBuses error', e);
            }
        }

        async function loadAlerts() {
            try {
                const data = await fetchJSON('api/get_alerts.php');
                const tbody = document.querySelector('#alertsTable tbody');
                tbody.innerHTML = '';
                data.forEach(a => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${escapeHtml(a.time)}</td>
                        <td>${escapeHtml(a.type)}</td>
                        <td>${escapeHtml(a.bus)}</td>
                        <td><span class="status-badge ${a.level}">${escapeHtml(a.status)}</span></td>
                    `;
                    tbody.appendChild(tr);
                });
            } catch (e) {
                console.error('loadAlerts error', e);
            }
        }

        function viewBus(busId) {
            alert('View bus details for Bus ID: ' + busId + '\n\nThis feature will be implemented to show detailed bus information.');
        }

        function editBus(busId) {
            alert('Edit bus for Bus ID: ' + busId + '\n\nThis feature will be implemented to edit bus information.');
        }

        window.onload = async function() {
            showSection('dashboard');
            try{
                showLoader('Loading dashboard data...');
                // update progress text as each fetch completes
                const pStats = loadStats().then(()=> setLoaderProgress('Loaded stats'));
                const pBuses = loadBuses().then(()=> setLoaderProgress('Loaded buses'));
                const pAlerts = loadAlerts().then(()=> setLoaderProgress('Loaded alerts'));

                await Promise.all([pStats, pBuses, pAlerts]);
            }catch(e){
                console.error('Initial load error', e);
            }finally{
                // ensure loader hidden even on error
                hideLoader();
            }

            // Auto-refresh data every 30 seconds
            setInterval(() => {
                loadStats();
                loadBuses();
                loadAlerts();
            }, 30000);
        };
    </script>
</body>
</html>