<x-app-layout>
    <style>
        .container {
            padding: 20px;
        }

        .balance-section {
            display: flex;
            justify-content: space-between;
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }

        .balance-section div {
            text-align: center;
        }

        .balance-section div p {
            margin: 5px 0;
            font-size: 14px;
        }

        .balance-section div span {
            font-size: 24px;
            font-weight: bold;
            color: #27ae60;
        }

        .transactions {
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .transactions table {
            width: 100%;
            border-collapse: collapse;
        }

        .transactions th,
        .transactions td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #ddd;
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

        .apply-leave-btn {
            background-color: #e74c3c;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            float: right;
        }
    </style>
    <div class="pagetitle">
        <h1>Leaves</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Leaves</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="container">
            <div class="balance-section">
                <div>
                    <p>CL</p>
                    <span>3</span>
                </div>
                <div>
                    <p>PL</p>
                    <span>42</span>
                </div>
                <button class="apply-leave-btn" id="applyBtn" onclick="openPopup()">Apply Leave</button>
            </div>

            <h4>Leave Transactions</h4>
            <div class="transactions">
                <table>
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Duration</th>
                            <th>Days</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>EL</td>
                            <td>02-11-2024 - 02-11-2024</td>
                            <td>1</td>
                            <td><span class="status">Approved</span></td>
                        </tr>
                        <tr>
                            <td>CL</td>
                            <td>31-10-2024 - 31-10-2024</td>
                            <td>1</td>
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
