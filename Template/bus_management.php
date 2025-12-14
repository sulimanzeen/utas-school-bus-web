<?php
// IMPORTANT: this file is included from Dashboard.php
// DO NOT call session_start() here to avoid "session already started" notice.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Bus Management - Smart Bus System</title>
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

        .back-btn {
            padding: 0.5rem 1rem;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            text-decoration: none;
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

        .action-bar {
            background: white;
            padding: 1rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
        }

        .search-box {
            display: flex;
            align-items: center;
            background: #f5f7fa;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .search-box input {
            border: none;
            background: none;
            outline: none;
            width: 100%;
            font-size: 16px;
        }

        .action-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }

        .btn {
            padding: 0.75rem 1rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.9rem;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .stats-bar {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-box {
            background: white;
            padding: 1rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .stat-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: #333;
        }

        .stat-label {
            color: #666;
            font-size: 0.8rem;
            margin-top: 0.5rem;
        }

        .bus-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .bus-card {
            background: white;
            border-radius: 15px;
            padding: 1.25rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: all 0.3s;
        }

        .bus-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .bus-title {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .bus-icon {
            font-size: 2.5rem;
        }

        .bus-info h3 {
            color: #333;
            font-size: 1.1rem;
            margin-bottom: 0.25rem;
        }

        .bus-info p {
            color: #666;
            font-size: 0.85rem;
        }

        .status-badge {
            padding: 0.3rem 0.7rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .status-badge.active {
            background: #d4edda;
            color: #155724;
        }

        .status-badge.idle {
            background: #f8d7da;
            color: #721c24;
        }

        .status-badge.warning {
            background: #fff3cd;
            color: #856404;
        }

        .bus-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .detail-item {
            background: #f8f9ff;
            padding: 0.75rem;
            border-radius: 8px;
        }

        .detail-label {
            font-size: 0.75rem;
            color: #999;
            margin-bottom: 0.25rem;
        }

        .detail-value {
            font-weight: 600;
            color: #333;
            font-size: 0.9rem;
        }

        .progress-bar {
            width: 100%;
            height: 6px;
            background: #e0e0e0;
            border-radius: 4px;
            overflow: hidden;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            transition: width 0.3s;
        }

        .capacity-info {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
            color: #666;
        }

        .bus-actions {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .icon-btn {
            padding: 0.6rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.25rem;
        }

        .icon-btn.edit {
            background: #fff3e0;
            color: #f57c00;
        }

        .icon-btn.delete {
            background: #ffebee;
            color: #c62828;
        }

        .filter-tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .filter-tab {
            padding: 0.6rem 1rem;
            border: 2px solid #e0e0e0;
            background: white;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            font-size: 0.85rem;
            white-space: nowrap;
        }

        .filter-tab:hover {
            border-color: #667eea;
        }

        .filter-tab.active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            overflow-y: auto;
        }

        .modal-content {
            background: white;
            margin: 1rem;
            padding: 1.5rem;
            border-radius: 15px;
            max-width: 600px;
            position: relative;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        }

        .close {
            position: absolute;
            right: 1rem;
            top: 1rem;
            font-size: 1.8rem;
            cursor: pointer;
            color: #999;
        }

        .modal-title {
            color: #667eea;
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
        }

        /* Desktop styles */
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

            .action-bar {
                padding: 1.5rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .search-box {
                flex: 1;
                max-width: 400px;
                margin-bottom: 0;
            }

            .action-buttons {
                display: flex;
                width: auto;
            }

            .stats-bar {
                grid-template-columns: repeat(4, 1fr);
                gap: 1rem;
                margin-bottom: 2rem;
            }

            .stat-box {
                padding: 1.5rem;
            }

            .bus-grid {
                grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
                gap: 1.5rem;
            }

            .bus-card {
                padding: 1.5rem;
            }

            .bus-icon {
                font-size: 3rem;
            }

            .bus-info h3 {
                font-size: 1.3rem;
            }

            .modal-content {
                margin: 3% auto;
                padding: 2rem;
            }

            .modal-title {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .stats-bar {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <script>
    // Load loader assets with fallback so this page works both when opened
    // directly from Template/ and when included from Dashboard.php
    (function(){
        function loadCSS(path, fallback){
            var l = document.createElement('link');
            l.rel = 'stylesheet';
            l.href = path;
            l.onerror = function(){ if(fallback) loadCSS(fallback); };
            document.head.appendChild(l);
        }

        function loadJS(path, fallback, cb){
            var s = document.createElement('script');
            s.src = path;
            s.async = false;
            s.onload = function(){ if(cb) cb(); };
            s.onerror = function(){ if(fallback) loadJS(fallback, null, cb); else if(cb) cb(); };
            document.head.appendChild(s);
        }

        loadCSS('Template/loader.css', 'loader.css');
        loadJS('Template/loader.js', 'loader.js');
    })();
    </script>
</head>
<body>
    <!-- Page loader overlay -->
    <div id="page-loader" class="page-loader">
        <div class="loader-card">
            <div class="loader-brand">🚌</div>
            <div class="loader-info">
                <div class="loader-title">Bus Management</div>
                <div class="loader-sub">Loading data — please wait…</div>
            </div>
            <div class="spinner" aria-hidden="true"></div>
        </div>
    </div>
    <nav class="navbar">
        <div class="logo">
            <span>🚌</span>
            <span>Bus Management</span>
        </div>
        <a href="../Dashboard.php" class="back-btn">← Back to Dashboard</a>
    </nav>

    <div class="container">
        <div class="header">
            <h1>Bus Fleet</h1>
            <p>Manage buses & IoT devices</p>
        </div>

        <div class="action-bar">
            <div class="search-box">
                <span>🔍</span>
                <input type="text" placeholder="Search buses..." id="searchInput" oninput="searchBuses()">
            </div>
            <div class="action-buttons">
                <button class="btn btn-primary" onclick="openModal('addBusModal')">
                    ➕ Add Bus
                </button>
            </div>
        </div>

        <div class="stats-bar" id="statsBar">
            <!-- Dynamic stats will be loaded here -->
        </div>

        <div class="filter-tabs">
            <button class="filter-tab active" onclick="filterBuses('all')">All</button>
            <button class="filter-tab" onclick="filterBuses('active')">Active</button>
            <button class="filter-tab" onclick="filterBuses('idle')">Idle</button>
        </div>

        <div class="bus-grid" id="busGrid">
            <!-- Dynamic bus cards will be loaded here -->
        </div>
    </div>

    <!-- Add Bus Modal -->
    <div id="addBusModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addBusModal')">&times;</span>
            <h2 class="modal-title">Add New Bus</h2>
            <form id="addBusForm">
                <div class="form-group">
                    <label>Bus Model *</label>
                    <input name="bus_model" type="text" placeholder="e.g., Toyota Hiace" required>
                </div>
                <div class="form-group">
                    <label>Driver Name *</label>
                    <input name="bus_driver_name" type="text" placeholder="Enter driver name" required>
                </div>
                <div class="form-group">
                    <label>Capacity *</label>
                    <input name="bus_capacity" type="number" placeholder="Maximum seats" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Add Bus</button>
            </form>
        </div>
    </div>

    <!-- Edit Bus Modal -->
    <div id="editBusModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editBusModal')">&times;</span>
            <h2 class="modal-title">Edit Bus</h2>
            <form id="editBusForm">
                <input type="hidden" name="bus_id" id="edit_bus_id">
                <div class="form-group">
                    <label>Bus Model *</label>
                    <input name="bus_model" id="edit_bus_model" type="text" required>
                </div>
                <div class="form-group">
                    <label>Driver Name *</label>
                    <input name="bus_driver_name" id="edit_bus_driver_name" type="text" required>
                </div>
                <div class="form-group">
                    <label>Capacity *</label>
                    <input name="bus_capacity" id="edit_bus_capacity" type="number" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Update Bus</button>
            </form>
        </div>
    </div>

    <script>
        let allBuses = [];

        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
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
                const data = await fetchJSON('../api/get_bus_stats.php');
                const statsBar = document.getElementById('statsBar');
                statsBar.innerHTML = `
                    <div class="stat-box">
                        <div class="stat-icon">🚌</div>
                        <div class="stat-value">${data.total || 0}</div>
                        <div class="stat-label">Total Buses</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-icon">✅</div>
                        <div class="stat-value">${data.active || 0}</div>
                        <div class="stat-label">Active</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-icon">⏸️</div>
                        <div class="stat-value">${data.idle || 0}</div>
                        <div class="stat-label">Idle</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-icon">👨‍🎓</div>
                        <div class="stat-value">${data.total_students || 0}</div>
                        <div class="stat-label">Total Students</div>
                    </div>
                `;
            } catch (e) {
                console.error('loadStats error', e);
            }
        }

        async function loadBuses() {
            try {
                const data = await fetchJSON('../api/get_buses.php');
                allBuses = data;
                renderBuses(data);
            } catch (e) {
                console.error('loadBuses error', e);
            }
        }

        function renderBuses(buses) {
            const grid = document.getElementById('busGrid');
            
            if (buses.length === 0) {
                grid.innerHTML = '<div style="grid-column: 1/-1; text-align:center; padding:3rem; color:#666;">No buses found</div>';
                return;
            }

            grid.innerHTML = '';
            buses.forEach(b => {
                const load = (b.current_load ?? 0) + '/' + (b.bus_capacity ?? 0);
                const loadPercent = b.load_ratio * 100;
                const statusClass = b.status_class ?? 'idle';
                const statusText = b.status_text ?? 'Idle';
                const dataStatus = b.trip_status === 1 ? 'active' : 'idle';

                const card = document.createElement('div');
                card.className = 'bus-card';
                card.setAttribute('data-status', dataStatus);
                card.setAttribute('data-search', `${b.bus_name} ${b.bus_driver_name}`.toLowerCase());
                
                card.innerHTML = `
                    <div class="bus-card-header">
                        <div class="bus-title">
                            <div class="bus-icon">🚌</div>
                            <div class="bus-info">
                                <h3>${escapeHtml(b.bus_name)}</h3>
                                <p>ID: ${b.bus_id}</p>
                            </div>
                        </div>
                        <span class="status-badge ${statusClass}">${statusText}</span>
                    </div>

                    <div class="bus-details">
                        <div class="detail-item">
                            <div class="detail-label">Driver</div>
                            <div class="detail-value">${escapeHtml(b.bus_driver_name)}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Capacity</div>
                            <div class="detail-value">${b.bus_capacity} Seats</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Model</div>
                            <div class="detail-value">${escapeHtml(b.bus_name)}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Status</div>
                            <div class="detail-value">${b.trip_status === 1 ? '🟢 On Trip' : '🔴 Idle'}</div>
                        </div>
                    </div>

                    <div class="progress-bar">
                        <div class="progress-fill" style="width: ${loadPercent}%"></div>
                    </div>
                    <div class="capacity-info">
                        <span>Load: ${load}</span>
                        <span>${Math.round(loadPercent)}%</span>
                    </div>

                    <div class="bus-actions">
                        <button class="icon-btn edit" onclick="editBus(${b.bus_id})">✏️ Edit</button>
                        <button class="icon-btn delete" onclick="deleteBus(${b.bus_id})">🗑️ Delete</button>
                    </div>
                `;
                grid.appendChild(card);
            });
        }

        function filterBuses(status) {
            document.querySelectorAll('.filter-tab').forEach(tab => tab.classList.remove('active'));
            event.target.classList.add('active');
            
            const cards = document.querySelectorAll('.bus-card');
            cards.forEach(card => {
                const cardStatus = card.getAttribute('data-status');
                if (status === 'all') {
                    card.style.display = 'block';
                } else if (cardStatus === status) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function searchBuses() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const cards = document.querySelectorAll('.bus-card');
            
            cards.forEach(card => {
                const searchData = card.getAttribute('data-search');
                card.style.display = searchData.includes(searchTerm) ? 'block' : 'none';
            });
        }

        async function editBus(busId) {
            const bus = allBuses.find(b => b.bus_id === busId);
            if (!bus) return;

            document.getElementById('edit_bus_id').value = bus.bus_id;
            document.getElementById('edit_bus_model').value = bus.bus_name.replace(/ #\d+$/, '');
            document.getElementById('edit_bus_driver_name').value = bus.bus_driver_name;
            document.getElementById('edit_bus_capacity').value = bus.bus_capacity;
            
            openModal('editBusModal');
        }

        async function deleteBus(busId) {
            if (!confirm('Are you sure you want to delete this bus? This action cannot be undone.')) {
                return;
            }

            try {
                const res = await fetch('../api/delete_bus.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({ bus_id: busId })
                });
                const json = await res.json();
                
                if (json.status === 1) {
                    alert('✅ Bus deleted successfully!');
                    loadBuses();
                    loadStats();
                } else {
                    alert(json.error || 'Failed to delete bus');
                }
            } catch (err) {
                console.error('deleteBus error', err);
                alert('Error deleting bus');
            }
        }

        document.getElementById('addBusForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const form = e.target;
            const payload = {
                bus_model: form.bus_model.value,
                bus_driver_name: form.bus_driver_name.value,
                bus_capacity: parseInt(form.bus_capacity.value)
            };

            try {
                const res = await fetch('../api/add_bus.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(payload)
                });
                const json = await res.json();
                
                if (json.status === 1) {
                    alert('✅ Bus added successfully!');
                    closeModal('addBusModal');
                    form.reset();
                    loadBuses();
                    loadStats();
                } else {
                    alert(json.error || 'Failed to add bus');
                }
            } catch (err) {
                console.error('addBus error', err);
                alert('Error adding bus');
            }
        });

        document.getElementById('editBusForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const form = e.target;
            const payload = {
                bus_id: parseInt(form.bus_id.value),
                bus_model: form.bus_model.value,
                bus_driver_name: form.bus_driver_name.value,
                bus_capacity: parseInt(form.bus_capacity.value)
            };

            try {
                const res = await fetch('../api/update_bus.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(payload)
                });
                const json = await res.json();
                
                if (json.status === 1) {
                    alert('✅ Bus updated successfully!');
                    closeModal('editBusModal');
                    loadBuses();
                    loadStats();
                } else {
                    alert(json.error || 'Failed to update bus');
                }
            } catch (err) {
                console.error('updateBus error', err);
                alert('Error updating bus');
            }
        });

        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        };

        function _waitForLoaderReady(timeout=2000){
            if(window.showLoader) return Promise.resolve();
            return new Promise(resolve => {
                var t = setInterval(()=>{ if(window.showLoader){ clearInterval(t); resolve(); } }, 50);
                setTimeout(()=>{ clearInterval(t); resolve(); }, timeout);
            });
        }

        window.onload = async function() {
            try{
                await _waitForLoaderReady();
                if(window.showLoader) showLoader('Loading buses and stats...');

                const p1 = loadStats().then(()=> { if(window.setLoaderProgress) setLoaderProgress('Loaded stats'); });
                const p2 = loadBuses().then(()=> { if(window.setLoaderProgress) setLoaderProgress('Loaded buses'); });
                await Promise.all([p1, p2]);
            }catch(e){
                console.error('initial load error', e);
            }finally{
                if(window.hideLoader) hideLoader();
            }

            // Auto-refresh every 30 seconds
            setInterval(() => {
                loadStats();
                loadBuses();
            }, 30000);
        };
    </script>
</body>
</html>