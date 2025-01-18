<x-app-layout>
    <style>
        .container {
            padding: 10px;
        }

        .transactions {
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            min-height: 400px;
            overflow-x: auto;
            /* Enable horizontal scrolling */
        }

        .transactions table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
            /* Ensure minimum width for the table */
        }

        .transactions th,
        .transactions td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #ddd;
            white-space: nowrap;
            /* Prevent text from wrapping */
        }

        .transactions th {
            background-color: #f4f4f4;
        }

        .status {
            color: #fff;
            background-color: #27ae60;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            text-align: center;
        }


        /* Popup Styles */
        .leave-popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .popup-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 400px;
        }

        .popup-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .popup-header h3 {
            margin: 0;
        }

        .popup-body {
            margin: 20px 0;
        }

        .popup-body label {
            font-size: 14px;
            margin-bottom: 5px;
            display: block;
        }

        .popup-body input,
        .popup-body select,
        .popup-body textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .popup-footer {
            text-align: right;
        }

        .popup-footer button {
            background-color: #e74c3c;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>

    <style>
        .leave-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .leave-card .leave-type {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            width: 80px;
            text-align: center;
            font-weight: bold;
            margin-right: 10px;
        }

        .leave-card .btn {
            margin-left: auto;
        }

        @media (max-width: 768px) {
            .leave-card {
                flex-direction: row;
                font-size: 15px;
            }


            .leave-card .btn {
                font-size: 15px;
                margin-left: 0;
                align-self: center;
            }
        }
    </style>
    <div class="pagetitle">
        <h1>Leaves</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Leaves</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">

        {{-- <div class="container mt-4"> --}}
        <div class="leave-card">
            <div class="leave-type">
                <span>CL</span>
                <span>10/25</span>
            </div>
            <div class="leave-type">
                <span>PL</span>
                <span>0/12</span>
            </div>
            <div class="leave-type">
                <span>ML</span>
                <span>2/70</span>
            </div>
            <button class="btn btn-primary" id="applyBtn" onclick="openPopup()">Apply Leave</button>
        </div>





        {{-- <div class="container"> --}}
        <div class="transactions mt-4">
            <h4>Leave Transactions</h4>

            <table>
                <thead>
                    <tr>
                        <th>SL No</th>
                        <th>Type</th>
                        <th>Duration</th>
                        <th>Days</th>
                        <th>Remarks</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>EL</td>
                        <td>02-11-2024 - 02-11-2024</td>
                        <td>1 Day</td>
                        <td>Personal</td>
                        <td><span class="status">Approved</span></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>CL</td>
                        <td>31-10-2024 - 31-10-2024</td>
                        <td>3 Days</td>
                        <td>Personal</td>
                        <td><span class="status">Approved</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>

        <!-- Popup -->
        <div class="leave-popup" id="popup">
            <div class="popup-content">
                <div class="popup-header">
                    <h3>Apply Leave</h3>
                    <button onclick="closePopup()">X</button>
                </div>
                <div class="popup-body">
                    <label for="leave-type">Leave Type</label>
                    <select id="leave-type">
                        <option value="CL">CL</option>
                        <option value="PL">PL</option>
                        <option value="EL">EL</option>
                    </select>

                    <label for="start-date">Start Date</label>
                    <input type="date" id="start-date">

                    <label for="end-date">End Date</label>
                    <input type="date" id="end-date">

                    <label for="reason">Reason</label>
                    <textarea id="reason" rows="4"></textarea>
                </div>
                <div class="popup-footer">
                    <button onclick="submitLeave()">Submit</button>
                </div>
            </div>
        </div>
    </section>
    <script>
        const applyBtn = document.getElementById('applyBtn');
        applyBtn.addEventListener('close', openPopup);
        const popup = document.getElementById('popup');

        function openPopup() {
            popup.style.display = 'flex';
        }

        function closePopup() {
            popup.style.display = 'none';
        }

        function submitLeave() {
            // Logic for leave submission
            alert('Leave applied successfully!');
            closePopup();
        }
    </script>


</x-app-layout>
