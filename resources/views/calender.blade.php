<x-app-layout>

    <style>
        /* * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                display: grid;
                width: 100%;
                min-height: 100vh;
                place-items: center;
                background-color: #f4f4f9;
                font-family: 'Roboto', sans-serif;
                padding: 20px;
            } */

        #calendar {
            width: 100%;
            max-width: auto;
            display: flex;
            flex-direction: column;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            gap: 10px;
        }

        #calendar .toprow {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        #calendar .days,
        #calendar #dates {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            text-align: center;
            gap: 10px;
        }

        #calendar #dates {
            min-height: 270px;
        }

        #calendar .days {
            padding: 8px;
            font-weight: bold;
            color: #ffff;
            background: #1d00c5;
        }

        #calendar #dates div {
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ddd;
            height: 50px;
            border-radius: 5px;
            cursor: pointer;
            position: relative;
        }

        #calendar #dates div.absent {
            background-color: #ffab0f;
            color: white;
        }

        #calendar #dates div.employee-leave {
            background-color: #ff00bf;
            color: white;
        }


        #calendar #dates div.attended {
            background-color: #006e00;
            color: white;
        }

        #calendar #dates div.company-leave {
            background-color: #ff2c2c;
            color: white;
        }

        #calendar #dates div.week-off {
            background-color: #640101;
            color: white;
        }

        #calendar #dates div.today {
            color: #000000;
            border: 2px solid #008000;
            background-color: #76e976;
            font-weight: bold;
        }

        #calendar #dates div:hover::after {
            content: attr(data-info);
            position: absolute;
            bottom: -30px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #333;
            color: #fff;
            padding: 5px 10px;
            font-size: 0.8em;
            border-radius: 3px;
            white-space: nowrap;
            z-index: 10;
            display: block;
        }


        button,
        select,
        input {
            padding: 5px;
        }

        input {
            width: 70px;
            text-align: center;
        }

        /* color indicator area */
        #calendar .color-indicator {
            display: flex;
            justify-content: space-between;
            padding-bottom: 10px;
            font-size: 0.9em;
            color: #333;
        }

        #calendar .color-indicator div {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        #calendar .color-indicator div span {
            width: 20px;
            height: 20px;
            border-radius: 3px;
            display: inline-block;
        }

        /* Hide the tooltip for empty cells (cells without data-info) */
        #calendar #dates div.empty:hover::after,
        #calendar #dates div:not([data-info]):empty:hover::after {
            content: none;
            display: none;
            cursor: not-allowed;
        }
    </style>
    <style>
        .select {
            display: flex;
            align-items: center;
            gap: 10px;
            background-color: #f4f4f4;
            border-radius: 8px;
        }

        select,
        input[type="number"] {
            padding: 8px 10px;
            font-size: 15px;
            border-radius: 5px;
            border: 1px solid;
            outline: none;
            transition: border-color 0.3s ease;
            width: 100%;
            max-width: 120px;
        }

        select:focus,
        input[type="number"]:focus {
            border-color: #27ae60;
        }

        input[type="number"] {
            text-align: center;
            -moz-appearance: textfield;
            /* Remove up/down arrows for Firefox */
        }

        /* Style the select dropdown */
        select {
            appearance: none;
            /* Remove default arrow */
            background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2210%22 height=%226%22 viewBox=%220 0 10 6%22%3E%3Cpath fill=%22%23000%22 d=%22M5 6L0 0h10L5 6z%22/%3E%3C/svg%3E');
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 10px 6px;
        }

        /* Adjust hover effect */
        select:hover,
        input[type="number"]:hover {
            border-color: #ccc;
        }

        @media (max-width: 768px) {
            input[type="number"] {
                padding: 5px;
                width: 70%;
                max-width: 100px;
                /* Optional: Set a width limit */
            }
        }
    </style>

    <div class="pagetitle">
        <h1>Calender</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Calender</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div id="calendar">

            <div class="color-indicator d-flex flex-wrap gap-3 justify-content-center">
                <div>
                    <span style="background-color: #ff2c2c;"></span> Holiday
                </div>
                <div>
                    <span style="background-color: #640101;"></span> Week Off
                </div>
                <div>
                    <span style="background-color: #ffa500;"></span> Absent
                </div>
                <div>
                    <span style="background-color: #ff00bf;"></span> Leave
                </div>
                <div>
                    <span style="background-color: #006e00;"></span> Attended
                </div>
                <div>
                    <span style="background-color: #76e976; border: 2px solid #008000;"></span> Today
                </div>
            </div>

            <div class="toprow d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
                <div class="select custom-select">
                    <select name="month" id="select_month">
                        <option value="0">January</option>
                        <option value="1">February</option>
                        <option value="2">March</option>
                        <option value="3">April</option>
                        <option value="4">May</option>
                        <option value="5">June</option>
                        <option value="6">July</option>
                        <option value="7">August</option>
                        <option value="8">September</option>
                        <option value="9">October</option>
                        <option value="10">November</option>
                        <option value="11">December</option>
                    </select>
                    <input type="number" value="2020" id="select_year">
                </div>
                <div class="navigate">
                    <button class="btn btn-primary" id="prev_month"><i class="fas fa-chevron-left"></i></button>
                    <button class="btn btn-secondary" id="curr_month">Current</button>
                    <button class="btn btn-primary" id="next_month"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
            <div class="days">
                <div>SU</div>
                <div>MO</div>
                <div>TU</div>
                <div>WE</div>
                <div>TH</div>
                <div>FR</div>
                <div>SA</div>
            </div>
            <div id="dates"></div>
        </div>


        <script>
            let select_month = document.getElementById('select_month');
            let select_year = document.getElementById('select_year');
            let btn_prev = document.getElementById('prev_month');
            let btn_next = document.getElementById('next_month');
            let btn_curr = document.getElementById('curr_month');
            let calendar_dates = document.getElementById('dates');

            let calendarData = {
                companyLeaves: [],
                employeeAbsent: [],
                employeeLeaves: [],
                attendedDates: []
            };

            const weeklyOffs = [0]; // Sundays
            const saturdayOffs = [2, 4]; // 2nd and 4th Saturdays

            // Initialize with current year and month
            const today = new Date();
            let currentYear = today.getFullYear();
            let currentMonth = today.getMonth();

            // Set the dropdowns to current month and year on page load
            select_year.value = currentYear;
            select_month.value = currentMonth;

            // Fetch data for the selected month and year
            function fetchCalendarData(year, month) {
                $('#loading-overlay').addClass('d-flex');
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: '{{ route('getCalendarData') }}',
                        method: 'GET',
                        data: {
                            year: year,
                            month: month + 1 // Backend expects 1-based month
                        },
                        success: function(response) {
                            calendarData.employeeLeaves = response.employee_leave;
                            calendarData.employeeAbsent = response.employee_absent;
                            calendarData.attendedDates = response.attended_dates;
                            calendarData.companyLeaves = response.company_leaves;
                            console.log(response);

                            resolve();
                            $('#loading-overlay').removeClass('d-flex');
                        },
                        error: function(error) {
                            console.error('Error fetching calendar data:', error);
                            reject(error);
                        }
                    });
                });
            }

            // Fetch and generate calendar on page load
            fetchCalendarData(currentYear, currentMonth).then(() => {
                generateDates();
            });

            // Event listeners for navigation
            select_month.addEventListener("change", onMonthChange);
            select_year.addEventListener("change", onMonthChange);

            btn_prev.addEventListener("click", () => switchMonth(-1));
            btn_next.addEventListener("click", () => switchMonth(1));
            btn_curr.addEventListener("click", () => {
                currentYear = today.getFullYear();
                currentMonth = today.getMonth();
                updateDropdowns();
                fetchCalendarData(currentYear, currentMonth).then(() => {
                    generateDates();
                });
            });

            // Handle month or year change
            function onMonthChange() {
                currentYear = parseInt(select_year.value);
                currentMonth = parseInt(select_month.value);
                fetchCalendarData(currentYear, currentMonth).then(() => {
                    generateDates();
                });
            }

            // Switch month and fetch new data
            function switchMonth(dir) {
                let newDate = new Date(currentYear, currentMonth + dir, 1);
                currentYear = newDate.getFullYear();
                currentMonth = newDate.getMonth();
                updateDropdowns(); // Update dropdowns after switching
                fetchCalendarData(currentYear, currentMonth).then(() => {
                    generateDates();
                });
            }

            // Update dropdowns to match current year and month
            function updateDropdowns() {
                select_year.value = currentYear;
                select_month.value = currentMonth;
            }

            // Generate calendar structure
            function generateDates() {
                calendar_dates.innerHTML = '';
                let daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
                let firstDay = new Date(currentYear, currentMonth, 1).getDay();

                // Fill initial empty cells for alignment
                for (let i = 0; i < firstDay; i++) {
                    calendar_dates.append(createCell());
                }

                // Add days of the month
                let saturdayCount = 0;
                for (let day = 1; day <= daysInMonth; day++) {
                    let date = new Date(currentYear, currentMonth, day);
                    let dateStr = formatDate(date);

                    let cell = createCell(day);

                    // Mark special dates
                    if (dateStr === formatDate(today)) {
                        cell.classList.add('today');
                        cell.setAttribute('data-info', 'Today');
                    }

                    // Check for employee Absent
                    if (calendarData.employeeAbsent.includes(dateStr)) {
                        cell.classList.add('absent');
                        cell.setAttribute('data-info', 'Absent');
                    }

                    // Check for attendance
                    if (calendarData.attendedDates.includes(dateStr)) {
                        cell.classList.add('attended');
                        cell.setAttribute('data-info', 'Attended');
                    }
                    // Check for Employee leaves
                    let employeeLeave = calendarData.employeeLeaves.find(item => item.leave_date === dateStr);
                    if (employeeLeave) {
                        cell.classList.add('employee-leave');
                        cell.setAttribute('data-info', `Leave: ${employeeLeave.remarks}`);
                    }

                    // Check for company leaves
                    let leave = calendarData.companyLeaves.find(item => item.leave_date === dateStr);
                    if (leave) {
                        cell.classList.add('company-leave');
                        cell.setAttribute('data-info', `Holiday: ${leave.reason}`);
                    }

                    // Mark weekly offs (Sundays)
                    if (weeklyOffs.includes(date.getDay())) {
                        cell.classList.add('week-off');
                        cell.setAttribute('data-info', 'Week Off');
                    }

                    // Mark 2nd and 4th Saturdays
                    if (isSaturdayOff(date, saturdayCount)) {
                        cell.classList.add('week-off');
                        cell.setAttribute('data-info', 'Weekly Off');
                    }

                    // Increment Saturday count
                    if (date.getDay() === 6) {
                        saturdayCount++;
                    }
                    calendar_dates.append(cell);
                    // If there's no event data, add the 'empty' class
                    if (!cell.hasAttribute('data-info')) {
                        cell.classList.add('empty');
                    }

                }
            }

            // Check if the date is a 2nd or 4th Saturday
            function isSaturdayOff(date, saturdayCount) {
                return date.getDay() === 6 && saturdayOffs.includes(saturdayCount + 1); // Saturday count is 1-based
            }

            // Create a calendar cell
            function createCell(content = '') {
                let cell = document.createElement('div');
                cell.textContent = content;
                return cell;
            }

            // Format date to YYYY-MM-DD
            function formatDate(date) {
                return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
            }
        </script>

</x-app-layout>
