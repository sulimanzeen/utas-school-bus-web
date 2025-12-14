<?php
// IMPORTANT: this file is included from Dashboard.php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Student Management - Smart Bus System</title>
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
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }

        .btn {
            padding: 0.75rem 1rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
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
            text-align: center;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: #667eea;
        }

        .stat-label {
            color: #666;
            font-size: 0.8rem;
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
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #f0f0f0;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #333;
        }

        .filter-tabs {
            display: flex;
            gap: 0.5rem;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .filter-tab {
            padding: 0.5rem 1rem;
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

        .table-container {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
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

        tr:hover {
            background: #f8f9ff;
        }

        .student-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .student-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .student-details h4 {
            color: #333;
            margin-bottom: 0.25rem;
            font-size: 0.9rem;
        }

        .student-details p {
            color: #666;
            font-size: 0.75rem;
        }

        .status-badge {
            display: inline-block;
            padding: 0.3rem 0.6rem;
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
            background: #fff3e0;
            color: #f57c00;
        }

        .icon-btn.delete {
            background: #ffebee;
            color: #c62828;
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
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
        }

        .form-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.5rem;
        }

        .btn-cancel {
            background: #e0e0e0;
            color: #666;
            flex: 1;
        }

        .btn-submit {
            flex: 1;
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
                flex-wrap: wrap;
                gap: 1rem;
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

            .stat-value {
                font-size: 2rem;
            }

            .card {
                padding: 1.5rem;
            }

            .card-title {
                font-size: 1.3rem;
            }

            .filter-tabs {
                width: auto;
            }

            .filter-tab {
                font-size: 0.9rem;
            }

            th, td {
                padding: 1rem;
                font-size: 1rem;
            }

            .student-avatar {
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
            }

            .student-details h4 {
                font-size: 1rem;
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
        }
    </style>
</head>
<body>
    <!-- Page loader overlay -->
    <div id="page-loader" class="page-loader">
        <div class="loader-card">
            <div class="loader-brand">👨‍🎓</div>
            <div class="loader-info">
                <div class="loader-title">Student Management</div>
                <div class="loader-sub">Loading students, buses, and parents…</div>
            </div>
            <div class="spinner" aria-hidden="true"></div>
        </div>
    </div>

    <link rel="stylesheet" href="loader.css">
    <nav class="navbar">
        <div class="logo">
            <span>👨‍🎓</span>
            <span>Students</span>
        </div>
        <a href="../Dashboard.php" class="back-btn">← Back to Dashboard</a>
    </nav>

    <div class="container">
        <div class="header">
            <h1>Student Management</h1>
            <p>Manage profiles & RFID</p>
        </div>

        <div class="action-bar">
            <div class="search-box">
                <span>🔍</span>
                <input type="text" placeholder="Search students..." id="searchInput" oninput="searchStudents()">
            </div>
            <div class="action-buttons">
                <button class="btn btn-primary" onclick="openModal('addStudentModal')">
                    ➕ Add New
                </button>
            </div>
        </div>

        <div class="stats-bar" id="statsBar">
            <!-- Dynamic stats -->
        </div>

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">All Students</h2>
                <div class="filter-tabs">
                    <button class="filter-tab active" onclick="filterStudents('all')">All</button>
                    <button class="filter-tab" onclick="filterStudents('assigned')">Assigned</button>
                    
                </div>
            </div>

            <div class="table-container">
                <table id="studentsTable">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>RFID</th>
                            <th>Parent</th>
                            <th>Bus</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dynamic content -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Student Modal -->
    <div id="addStudentModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addStudentModal')">&times;</span>
            <h2 class="modal-title">Add New Student</h2>
            <form id="addStudentForm">
                <div class="form-group">
                    <label>Student Name *</label>
                    <input name="student_name" type="text" placeholder="Enter full name" required>
                </div>
                <div class="form-group">
                    <label>RFID Card Number *</label>
                    <input name="student_rfid" type="text" placeholder="e.g., 222814543110" required>
                </div>
                <div class="form-group">
                    <label>Parent *</label>
                    <select name="parent_id" id="parentSelect" required>
                        <option value="">Select Parent</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Assign Bus *</label>
                    <select name="student_bus_id" id="busSelect" required>
                        <option value="">Select Bus</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-cancel" onclick="closeModal('addStudentModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-submit">Add Student</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Student Modal -->
    <div id="editStudentModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editStudentModal')">&times;</span>
            <h2 class="modal-title">Edit Student</h2>
            <form id="editStudentForm">
                <input type="hidden" name="student_id" id="edit_student_id">
                <div class="form-group">
                    <label>Student Name *</label>
                    <input name="student_name" id="edit_student_name" type="text" required>
                </div>
                <div class="form-group">
                    <label>RFID Card Number *</label>
                    <input name="student_rfid" id="edit_student_rfid" type="text" required>
                </div>
                <div class="form-group">
                    <label>Parent *</label>
                    <select name="parent_id" id="edit_parentSelect" required>
                        <option value="">Select Parent</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Assign Bus *</label>
                    <select name="student_bus_id" id="edit_busSelect" required>
                        <option value="">Select Bus</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-cancel" onclick="closeModal('editStudentModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-submit">Update Student</button>
                </div>
            </form>
        </div>
    </div>

    <script src="loader.js"></script>
    <script>
        let allStudents = [];
        let allBuses = [];
        let allParents = [];

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
                const data = await fetchJSON('../api/get_student_stats.php');
                const statsBar = document.getElementById('statsBar');
                statsBar.innerHTML = `
                    <div class="stat-box">
                        <div class="stat-value">${data.total || 0}</div>
                        <div class="stat-label">Total</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-value">${data.assigned || 0}</div>
                        <div class="stat-label">Assigned</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-value">${data.unassigned || 0}</div>
                        <div class="stat-label">Unassigned</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-value">${data.total_buses || 0}</div>
                        <div class="stat-label">Buses</div>
                    </div>
                `;
            } catch (e) {
                console.error('loadStats error', e);
            }
        }

        async function loadStudents() {
            try {
                const data = await fetchJSON('../api/get_students.php');
                allStudents = data;
                renderStudents(data);
            } catch (e) {
                console.error('loadStudents error', e);
            }
        }

        async function loadBuses() {
            try {
                allBuses = await fetchJSON('../api/get_buses.php');
                populateBusSelects();
            } catch (e) {
                console.error('loadBuses error', e);
            }
        }

        async function loadParents() {
            try {
                allParents = await fetchJSON('../api/get_parents.php');
                populateParentSelects();
            } catch (e) {
                console.error('loadParents error', e);
            }
        }

        function populateBusSelects() {
            const selects = [document.getElementById('busSelect'), document.getElementById('edit_busSelect')];
            selects.forEach(select => {
                const currentValue = select.value;
                select.innerHTML = '<option value="">Select Bus</option>';
                allBuses.forEach(bus => {
                    const option = document.createElement('option');
                    option.value = bus.bus_id;
                    option.textContent = bus.bus_name + ' - ' + bus.bus_driver_name;
                    select.appendChild(option);
                });
                if (currentValue) select.value = currentValue;
            });
        }

        function populateParentSelects() {
            const selects = [document.getElementById('parentSelect'), document.getElementById('edit_parentSelect')];
            selects.forEach(select => {
                const currentValue = select.value;
                select.innerHTML = '<option value="">Select Parent</option>';
                allParents.forEach(parent => {
                    const option = document.createElement('option');
                    option.value = parent.parent_id;
                    option.textContent = parent.parent_name + ' (' + parent.parent_tel + ')';
                    select.appendChild(option);
                });
                if (currentValue) select.value = currentValue;
            });
        }

        function renderStudents(students) {
            const tbody = document.querySelector('#studentsTable tbody');
            
            if (students.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" style="text-align:center; padding:3rem; color:#666;">No students found</td></tr>';
                return;
            }

            tbody.innerHTML = '';
            students.forEach(s => {
                const initial = s.student_name.charAt(0).toUpperCase();
                const busText = s.bus_name || 'Not Assigned';
                const statusClass = s.student_bus_id ? 'active' : 'inactive';
                const statusText = s.student_bus_id ? 'Assigned' : 'Unassigned';
                const dataStatus = s.student_bus_id ? 'assigned' : 'unassigned';

                const tr = document.createElement('tr');
                tr.setAttribute('data-status', dataStatus);
                tr.setAttribute('data-search', `${s.student_name} ${s.student_rfid} ${s.parent_name}`.toLowerCase());
                
                tr.innerHTML = `
                    <td>
                        <div class="student-info">
                            <div class="student-avatar">${initial}</div>
                            <div class="student-details">
                                <h4>${escapeHtml(s.student_name)}</h4>
                                <p>ID: ${s.student_id}</p>
                            </div>
                        </div>
                    </td>
                    <td>${escapeHtml(s.student_rfid)}</td>
                    <td>${escapeHtml(s.parent_name)}</td>
                    <td>${escapeHtml(busText)}</td>
                    <td><span class="status-badge ${statusClass}">${statusText}</span></td>
                    <td>
                        <div class="action-btns">
                            <button class="icon-btn edit" onclick="editStudent(${s.student_id})">✏️</button>
                            <button class="icon-btn delete" onclick="deleteStudent(${s.student_id})">🗑️</button>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        function filterStudents(filter) {
            document.querySelectorAll('.filter-tab').forEach(tab => tab.classList.remove('active'));
            event.target.classList.add('active');
            
            const rows = document.querySelectorAll('#studentsTable tbody tr');
            rows.forEach(row => {
                const status = row.getAttribute('data-status');
                if (filter === 'all') {
                    row.style.display = '';
                } else if (status === filter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function searchStudents() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#studentsTable tbody tr');
            rows.forEach(row => {
                const searchData = row.getAttribute('data-search');
                if (searchData) {
                    row.style.display = searchData.includes(searchTerm) ? '' : 'none';
                }
            });
        }

        async function editStudent(studentId) {
            const student = allStudents.find(s => s.student_id === studentId);
            if (!student) return;

            document.getElementById('edit_student_id').value = student.student_id;
            document.getElementById('edit_student_name').value = student.student_name;
            document.getElementById('edit_student_rfid').value = student.student_rfid;
            document.getElementById('edit_parentSelect').value = student.parent_id;
            document.getElementById('edit_busSelect').value = student.student_bus_id || '';
            
            openModal('editStudentModal');
        }

        async function deleteStudent(studentId) {
            const student = allStudents.find(s => s.student_id === studentId);
            if (!student) return;

            if (!confirm(`Are you sure you want to delete ${student.student_name}? This action cannot be undone.`)) {
                return;
            }

            try {
                const res = await fetch('../api/delete_student.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({ student_id: studentId })
                });
                const json = await res.json();
                
                if (json.status === 1) {
                    alert('✅ Student deleted successfully!');
                    loadStudents();
                    loadStats();
                } else {
                    alert(json.error || 'Failed to delete student');
                }
            } catch (err) {
                console.error('deleteStudent error', err);
                alert('Error deleting student');
            }
        }

        document.getElementById('addStudentForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const form = e.target;
            const payload = {
                student_name: form.student_name.value,
                student_rfid: form.student_rfid.value,
                parent_id: parseInt(form.parent_id.value),
                student_bus_id: parseInt(form.student_bus_id.value)
            };

            try {
                const res = await fetch('../api/add_student.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(payload)
                });
                const json = await res.json();
                
                if (json.status === 1) {
                    alert('✅ Student added successfully!');
                    closeModal('addStudentModal');
                    form.reset();
                    loadStudents();
                    loadStats();
                } else {
                    alert(json.error || 'Failed to add student');
                }
            } catch (err) {
                console.error('addStudent error', err);
                alert('Error adding student');
            }
        });

        document.getElementById('editStudentForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const form = e.target;
            const payload = {
                student_id: parseInt(form.student_id.value),
                student_name: form.student_name.value,
                student_rfid: form.student_rfid.value,
                parent_id: parseInt(form.parent_id.value),
                student_bus_id: parseInt(form.student_bus_id.value)
            };

            try {
                const res = await fetch('../api/update_student.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(payload)
                });
                const json = await res.json();
                
                if (json.status === 1) {
                    alert('✅ Student updated successfully!');
                    closeModal('editStudentModal');
                    loadStudents();
                    loadStats();
                } else {
                    alert(json.error || 'Failed to update student');
                }
            } catch (err) {
                console.error('updateStudent error', err);
                alert('Error updating student');
            }
        });

        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        };

        window.onload = async function() {
            try{
                showLoader('Loading students and related data...');
                const pStats = loadStats().then(()=> setLoaderProgress('Loaded stats'));
                const pBuses = loadBuses().then(()=> setLoaderProgress('Loaded buses'));
                const pParents = loadParents().then(()=> setLoaderProgress('Loaded parents'));
                const pStudents = loadStudents().then(()=> setLoaderProgress('Loaded students'));

                await Promise.all([pStats, pBuses, pParents, pStudents]);
            }catch(e){
                console.error('initial load error', e);
            }finally{
                hideLoader();
            }

            // Auto-refresh every 30 seconds
            setInterval(() => {
                loadStats();
                loadStudents();
            }, 30000);
        };
    </script>
</body>
</html>