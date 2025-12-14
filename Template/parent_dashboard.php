<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Parent Dashboard - Smart Bus Tracking</title>
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
            display: none;
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

        .dashboard-grid {
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
            font-size: 1.3rem;
            font-weight: 700;
            color: #333;
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.6rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-top: 0.5rem;
        }

        .status-badge.active {
            background: #d4edda;
            color: #155724;
        }

        .status-badge.inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .main-content {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .card {
            background: white;
            border-radius: 10px;
            padding: 1.25rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
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

        .map-placeholder {
            width: 100%;
            height: 250px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
            position: relative;
            overflow: hidden;
            text-align: center;
            padding: 1rem;
        }

        .map-btn {
            display: inline-block;
            background: rgba(255,255,255,0.95);
            color: #333;
            padding: 0.75rem 1.25rem;
            border-radius: 10px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 6px 20px rgba(0,0,0,0.12);
            transition: transform 160ms ease, box-shadow 160ms ease;
            text-align: center;
            width: 100%;
            max-width: 320px;
            margin: 0 auto;
        }

        .map-btn:hover { transform: translateY(-3px); box-shadow: 0 10px 26px rgba(0,0,0,0.16); }
        .map-btn.disabled { opacity: 0.6; pointer-events: none; }

        .bus-marker {
            position: absolute;
            font-size: 2.5rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .student-card {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: #f8f9ff;
            border-radius: 8px;
            margin-bottom: 1rem;
            position: relative;
            flex-wrap: wrap;
        }

        .student-card.on-bus {
            background: #d4edda;
            border: 2px solid #28a745;
        }

        .student-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.3rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .student-card.on-bus .student-avatar {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        }

        .student-info {
            flex: 1;
            min-width: 0;
        }

        .student-info h3 {
            color: #333;
            margin-bottom: 0.25rem;
            font-size: 1rem;
        }

        .student-info p {
            color: #666;
            font-size: 0.8rem;
        }

        .realtime-indicator {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 0.25rem 0.5rem;
            border-radius: 20px;
        }

        .realtime-indicator.on-bus {
            background: #28a745;
            color: white;
        }

        .realtime-indicator.off-bus {
            background: #6c757d;
            color: white;
        }

        .pulse-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: white;
            animation: pulse-dot 2s infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }

        .attendance-list {
            max-height: none;
        }

        .attendance-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 1rem;
            border-bottom: 1px solid #f0f0f0;
            gap: 0.5rem;
        }

        .attendance-item:last-child {
            border-bottom: none;
        }

        .attendance-date {
            color: #666;
            font-size: 0.8rem;
        }

        .attendance-status {
            padding: 0.25rem 0.6rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .attendance-status.present {
            background: #d4edda;
            color: #155724;
        }

        .attendance-status.absent {
            background: #f8d7da;
            color: #721c24;
        }

        .bus-info {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .info-item {
            padding: 0.75rem;
            background: #f8f9ff;
            border-radius: 8px;
        }

        .info-label {
            color: #666;
            font-size: 0.75rem;
            margin-bottom: 0.25rem;
        }

        .info-value {
            color: #333;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .no-data {
            text-align: center;
            padding: 2rem;
            color: #666;
        }

        /* Desktop styles */
        @media (min-width: 769px) {
            .navbar {
                padding: 1rem 2rem;
            }

            .logo {
                font-size: 1.5rem;
            }

            .user-info {
                display: block;
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

            .dashboard-grid {
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
                font-size: 1.8rem;
            }

            .main-content {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 2rem;
            }

            .map-container {
                grid-column: 1 / -1;
            }

            .card {
                padding: 1.5rem;
            }

            .card-title {
                font-size: 1.3rem;
            }

            .map-placeholder {
                height: 400px;
                font-size: 1.2rem;
            }

            .attendance-list {
                max-height: 300px;
                overflow-y: auto;
            }

            .bus-info {
                grid-template-columns: repeat(3, 1fr);
                gap: 1rem;
            }

            .info-item {
                padding: 1rem;
            }

            .info-label {
                font-size: 0.85rem;
            }

            .info-value {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 480px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .bus-info {
                grid-template-columns: 1fr;
            }

            .stat-card p {
                font-size: 0.75rem;
            }
        }
    </style>
    <script>
    // Robustly load loader assets (tries Template/ then root) and provide safe stubs
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
        addJS('Template/loader.js', 'loader.js', function(){ window.__loaderReady = true; });
    })();
    </script>
</head>
<body>
    <!-- Page loader overlay -->
    <div id="page-loader" class="page-loader">
        <div class="loader-card">
            <div class="loader-brand">🚌</div>
            <div class="loader-info">
                <div class="loader-title">Parent Dashboard</div>
                <div class="loader-sub">Fetching your children's data…</div>
            </div>
            <div class="spinner" aria-hidden="true"></div>
        </div>
    </div>

    <link rel="stylesheet" href="loader.css">
    <nav class="navbar">
        <div class="logo">
            <span>🚌</span>
            <span>Smart Bus</span>
        </div>
        <div class="user-menu">
            <div class="user-info">
                <div class="user-name" id="parentName">Parent</div>
                <div class="user-role">Parent</div>
            </div>
            <button class="logout-btn" onclick="logout()">Logout</button>
        </div>
    </nav>

    <div class="container">
        <div class="header">
            <h1 id="welcomeMessage">Welcome!</h1>
            <p>Track your children's bus in real-time</p>
        </div>

        <div class="dashboard-grid" id="statsGrid">
            <!-- Dynamic stats will be loaded here -->
        </div>

        <div class="main-content">
            <div class="card map-container">
                <div class="card-header">
                    <h2 class="card-title">Bus Information</h2>
                    
                </div>
                <div class="map-placeholder">
                    <div style="z-index: 10; position: relative; width:100%;">
                        <a id="openMapBtn" class="map-btn" href="" target="_blank" rel="noopener">Open in Google Maps</a>
                    </div>
                </div>
                
                <div class="bus-info" id="busInfo">
                    <!-- Dynamic bus info will be loaded here -->
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Your Children</h2>
                </div>
                <div id="studentsList">
                    <!-- Dynamic student cards will be loaded here -->
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Recent Attendance</h2>
                </div>
                <div class="attendance-list" id="attendanceList">
                    <!-- Dynamic attendance records will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script src="loader.js"></script>
    <script>
        let parentData = null;
        let studentsData = [];

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

        async function loadParentData() {
            try {
                const data = await fetchJSON('api/get_parent_dashboard.php');
                parentData = data;
                
                // Update header
                document.getElementById('welcomeMessage').textContent = `Welcome, ${data.parent_name}!`;
                document.getElementById('parentName').textContent = data.parent_name;
                
                // Load students
                studentsData = data.students || [];
                renderStats();
                renderStudents();
                renderBusInfo();
                renderAttendance();
                
            } catch (e) {
                console.error('loadParentData error', e);
                document.getElementById('statsGrid').innerHTML = '<div class="no-data">Unable to load data</div>';
            }
        }

        function renderStats() {
            const statsGrid = document.getElementById('statsGrid');
            const totalStudents = studentsData.length;
            
            if (totalStudents === 0) {
                statsGrid.innerHTML = '<div class="no-data" style="grid-column: 1/-1;">No students assigned</div>';
                return;
            }

            // Count students currently on bus (real-time from bus.student_list)
            const onBusCount = studentsData.filter(s => s.is_on_bus).length;
            
            // Get unique buses
            const buses = [...new Set(studentsData.map(s => s.bus_name).filter(b => b))];
            const busText = buses.length > 0 ? buses[0] : 'Not Assigned';
            
            // Calculate monthly attendance
            const thisMonth = studentsData.reduce((sum, s) => sum + (s.attendance_this_month || 0), 0);
            const totalDays = 20; // Approximate school days per month
            const attendancePercent = totalDays > 0 ? Math.round((thisMonth / (totalDays * totalStudents)) * 100) : 0;

            statsGrid.innerHTML = `
                <div class="stat-card">
                    <div class="stat-icon">👨‍👩‍👧‍👦</div>
                    <div class="stat-label">Your Children</div>
                    <div class="stat-value">${totalStudents}</div>
                    <span class="status-badge active">Registered</span>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">🚌</div>
                    <div class="stat-label">On Bus Now</div>
                    <div class="stat-value">${onBusCount}/${totalStudents}</div>
                    <span class="status-badge ${onBusCount > 0 ? 'active' : 'inactive'}">${onBusCount > 0 ? 'Live Status' : 'All Off Bus'}</span>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">🚐</div>
                    <div class="stat-label">Bus Number</div>
                    <div class="stat-value">${escapeHtml(busText)}</div>
                    <span class="status-badge ${buses.length > 0 ? 'active' : 'inactive'}">${buses.length > 0 ? 'Assigned' : 'Not Assigned'}</span>
                </div>

                
            `;
        }

        function renderStudents() {
            const container = document.getElementById('studentsList');
            
            if (studentsData.length === 0) {
                container.innerHTML = '<div class="no-data">No students assigned to your account</div>';
                return;
            }

            container.innerHTML = '';
            studentsData.forEach(student => {
                const initial = student.student_name.charAt(0).toUpperCase();
                const isOnBus = student.is_on_bus; // Real-time status from bus.student_list
                const lastAttendance = student.last_attendance || {};
                
                const card = document.createElement('div');
                card.className = `student-card ${isOnBus ? 'on-bus' : ''}`;
                card.innerHTML = `
                    <div class="student-avatar">${initial}</div>
                    <div class="student-info">
                        <h3>${escapeHtml(student.student_name)}</h3>
                        <p>ID: ${student.student_id}</p>
                        <p>RFID: ${escapeHtml(student.student_rfid)}</p>
                    </div>
                    <div class="realtime-indicator ${isOnBus ? 'on-bus' : 'off-bus'}">
                        <div class="pulse-dot"></div>
                        ${isOnBus ? 'ON BUS' : 'OFF BUS'}
                    </div>
                `;
                
                const busInfo = document.createElement('div');
                busInfo.className = 'bus-info';
                busInfo.style.marginTop = '0.75rem';
                
                if (lastAttendance.timestamp) {
                    const time = new Date(lastAttendance.timestamp).toLocaleTimeString('en-US', {
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    
                    busInfo.innerHTML = `
                        <div class="info-item">
                            <div class="info-label">Last Event</div>
                            <div class="info-value">${lastAttendance.type === 0 ? 'Boarded' : 'Exited'}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Time</div>
                            <div class="info-value">${time}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Bus</div>
                            <div class="info-value">${escapeHtml(student.bus_name || 'N/A')}</div>
                        </div>
                    `;
                } else {
                    busInfo.innerHTML = `
                        <div class="info-item">
                            <div class="info-label">Status</div>
                            <div class="info-value" style="color: #666;">${isOnBus ? 'Currently on bus' : 'No activity today'}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Bus</div>
                            <div class="info-value">${escapeHtml(student.bus_name || 'Not Assigned')}</div>
                        </div>
                    `;
                }
                
                card.appendChild(busInfo);
                container.appendChild(card);
            });
        }

        function renderBusInfo() {
            const container = document.getElementById('busInfo');
            
            if (studentsData.length === 0 || !studentsData[0].bus_driver_name) {
                container.innerHTML = '<div class="no-data" style="grid-column: 1/-1;">No bus assigned</div>';
                return;
            }

            const student = studentsData[0];
            const onBoardCount = studentsData.filter(s => s.is_on_bus).length; // Real-time count

            // Set map button href from the first available google_map field
            try {
                const mapSource = (studentsData.find(s => s.google_map && s.google_map.length > 0) || {}).google_map || '';
                const mapBtn = document.getElementById('openMapBtn');
                if (mapBtn) {
                    if (mapSource) {
                        mapBtn.href = mapSource;
                        mapBtn.classList.remove('disabled');
                        mapBtn.textContent = 'Open in Google Maps';
                    } else {
                        mapBtn.removeAttribute('href');
                        mapBtn.classList.add('disabled');
                        mapBtn.textContent = 'Map unavailable';
                    }
                }
            } catch (e) { console.error('map set error', e); }

            container.innerHTML = `
                <div class="info-item">
                    <div class="info-label">Driver</div>
                    <div class="info-value">${escapeHtml(student.bus_driver_name || 'N/A')}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Your Children On Board</div>
                    <div class="info-value" style="color: ${onBoardCount > 0 ? '#28a745' : '#666'};">${onBoardCount}/${studentsData.length}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Bus</div>
                    <div class="info-value">${escapeHtml(student.bus_name || 'N/A')}</div>
                </div>
            `;
        }

        function renderAttendance() {
            const container = document.getElementById('attendanceList');
            
            if (!parentData.recent_attendance || parentData.recent_attendance.length === 0) {
                container.innerHTML = '<div class="no-data">No recent attendance records</div>';
                return;
            }

            container.innerHTML = '';
            
            // Group attendance by date and student
            const attendanceByDate = {};
            parentData.recent_attendance.forEach(record => {
                const date = new Date(record.timestamp);
                const dateKey = date.toISOString().split('T')[0];
                
                if (!attendanceByDate[dateKey]) {
                    attendanceByDate[dateKey] = {};
                }
                
                if (!attendanceByDate[dateKey][record.student_id]) {
                    attendanceByDate[dateKey][record.student_id] = {
                        student_name: record.student_name,
                        checkIn: null,
                        checkOut: null
                    };
                }
                
                if (record.type === 0) {
                    attendanceByDate[dateKey][record.student_id].checkIn = date;
                } else {
                    attendanceByDate[dateKey][record.student_id].checkOut = date;
                }
            });

            // Sort dates descending
            const sortedDates = Object.keys(attendanceByDate).sort().reverse().slice(0, 10);
            
            sortedDates.forEach(dateKey => {
                const date = new Date(dateKey);
                const students = attendanceByDate[dateKey];
                
                Object.values(students).forEach(student => {
                    const item = document.createElement('div');
                    item.className = 'attendance-item';
                    
                    const checkInTime = student.checkIn ? student.checkIn.toLocaleTimeString('en-US', {hour: '2-digit', minute: '2-digit'}) : '--';
                    const checkOutTime = student.checkOut ? student.checkOut.toLocaleTimeString('en-US', {hour: '2-digit', minute: '2-digit'}) : '--';
                    
                    const wasPresent = student.checkIn !== null;
                    
                    item.innerHTML = `
                        <div>
                            <div style="font-weight: 600; color: #333; font-size: 0.9rem;">
                                ${date.toLocaleDateString('en-US', {weekday: 'short', month: 'short', day: 'numeric'})}
                            </div>
                            <div class="attendance-date">${escapeHtml(student.student_name)}</div>
                            <div class="attendance-date">
                                ${wasPresent ? `In: ${checkInTime} | Out: ${checkOutTime}` : 'No check-in recorded'}
                            </div>
                        </div>
                        <span class="attendance-status ${wasPresent ? 'present' : 'absent'}">
                            ${wasPresent ? 'Present' : 'Absent'}
                        </span>
                    `;
                    
                    container.appendChild(item);
                });
            });
        }

        function _waitForLoader(timeout = 2000){
            if(window.__loaderReady && window.showLoader) return Promise.resolve();
            return new Promise(res => {
                const t = setInterval(()=>{ if(window.showLoader && window.__loaderReady){ clearInterval(t); res(); } }, 50);
                setTimeout(()=>{ clearInterval(t); res(); }, timeout);
            });
        }

        window.onload = async function() {
            await _waitForLoader();
            try{
                if (window.showLoader) showLoader('Loading parent dashboard...');
                await loadParentData();
            }catch(e){
                console.error('initial load error', e);
            }finally{
                if (window.hideLoader) hideLoader();
            }

            // Auto-refresh every 10 seconds for real-time updates
            setInterval(() => {
                loadParentData();
            }, 10000);
        };
    </script>
</body>
</html>