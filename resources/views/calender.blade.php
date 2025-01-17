<x-app-layout>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Advanced Calendar</title>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

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

            #calendar .days {
                font-weight: bold;
                color: #333;
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

            #calendar #dates div.today {
                border: 2px solid green;
                background-color: lightgreen;
                font-weight: bold;
            }


            #calendar #dates div.week-off {
                background-color: lightblue;
                color: white;
            }

            #calendar #dates div.employee-leave {
                background-color: orange;
                color: white;
            }

            #calendar #dates div.attended {
                background-color: lightgreen;
                color: white;
            }

            #calendar #dates div.company-leave {
                background-color: lightcoral;
                color: white;
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
    </head>

    <body>
        <div class="pagetitle">
            <h1>Calender</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Calender</li>
                </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div id="calendar">

                <div class="color-indicator">
                    <div>
                        <span style="background-color: lightcoral;"></span> Holiday
                    </div>
                    <div>
                        <span style="background-color: lightblue;"></span> Week Off
                    </div>
                    <div>
                        <span style="background-color: orange;"></span> Absent
                    </div>
                    <div>
                        <span style="background-color: lightgreen;"></span> Attended
                    </div>
                    <div>
                        <span style="background-color: lightgreen; border: 2px solid green;"></span> Today
                    </div>
                </div>

                <div class="toprow">
                    <div class="select">
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
                        <button id="prev_month">Prev</button>
                        <button id="curr_month">Current</button>
                        <button id="next_month">Next</button>
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

            {{-- <script>
                let select_month = document.getElementById('select_month');
                let select_year = document.getElementById('select_year');
                let btn_prev = document.getElementById('prev_month');
                let btn_next = document.getElementById('next_month');
                let btn_curr = document.getElementById('curr_month');
                let calendar_dates = document.getElementById('dates');
                let today = new Date();

                let companyLeaves = [];
                let employeeLeaves = []; // Array for employee leaves with types
                let attendedDates = []; // Array for attended dates (just dates)

                // Function to fetch all the data and generate the calendar
                function fetchDataAndGenerateCalendar() {
                    // Use a single AJAX request to fetch all the required data
                    $.ajax({
                        url: '/attendance/data', // Adjust URL as necessary for the new combined endpoint
                        method: 'GET',
                        success: function(response) {
                            // Store the company leave dates along with their reasons
                            companyLeaves = response.company_leaves;
                            console.log(response);

                            // Store employee leaves and their types (e.g., CL, EL)
                            employeeLeaves = response.employee_leaves.map(item => ({
                                leave_date: item.leave_date,
                                leave_type: item.leave_type // CL, EL, etc.
                            }));

                            // Store the attended dates (just the dates without types)
                            attendedDates = response.attended_dates;

                            // Once all data is fetched, generate the calendar
                            generateDates();
                        },
                        error: function(error) {
                            console.error('Error fetching data:', error);
                        }
                    });
                }

                // Fetch the data and generate the calendar on page load
                fetchDataAndGenerateCalendar();

                const weeklyOffs = [0]; // Sundays
                const saturdayOffs = [1, 3]; // 2nd and 4th Saturday, or 'all' for all Saturdays

                // Set current month and year
                select_year.value = today.getFullYear();
                select_month.value = today.getMonth();

                // Event listeners
                select_month.addEventListener("change", generateDates);
                select_year.addEventListener("change", generateDates);
                btn_prev.addEventListener("click", () => switchMonth(-1));
                btn_next.addEventListener("click", () => switchMonth(1));
                btn_curr.addEventListener("click", () => switchMonth(0));

                function switchMonth(dir) {
                    if (dir === 0) {
                        select_year.value = today.getFullYear();
                        select_month.value = today.getMonth();
                    } else {
                        let current_date = new Date(select_year.value, select_month.value, 1);
                        let new_date = new Date(current_date.setMonth(current_date.getMonth() + dir));
                        select_year.value = new_date.getFullYear();
                        select_month.value = new_date.getMonth();
                    }
                    generateDates();
                }

                function generateDates() {
                    calendar_dates.innerHTML = '';
                    let month = parseInt(select_month.value);
                    let year = parseInt(select_year.value);

                    let first_day = new Date(year, month, 1).getDay();
                    let days_in_month = new Date(year, month + 1, 0).getDate();

                    // Fill in blank spaces for the first row
                    for (let i = 0; i < first_day; i++) {
                        calendar_dates.append(createCell());
                    }

                    let saturdayCount = 0; // To count Saturdays for marking 2nd and 4th Saturdays
                    for (let day = 1; day <= days_in_month; day++) {
                        // Create a new date for the specific day in the local timezone
                        let date = new Date(year, month, day);

                        // Format the date to YYYY-MM-DD in local timezone
                        let dateStr = date.getFullYear() + '-' +
                            String(date.getMonth() + 1).padStart(2, '0') + '-' +
                            String(date.getDate()).padStart(2, '0');

                        let cell = createCell(day);

                        // Get today's date in the local timezone
                        const todayStr = today.getFullYear() + '-' +
                            String(today.getMonth() + 1).padStart(2, '0') + '-' +
                            String(today.getDate()).padStart(2, '0');

                        // Mark special dates
                        if (dateStr === todayStr) {
                            cell.classList.add('today');
                            cell.setAttribute('data-info', 'Today');
                        }

                        // Check for company leaves
                        let companyLeave = companyLeaves.find(item => item.leave_date === dateStr);
                        if (companyLeave) {
                            cell.classList.add('company-leave');
                            cell.setAttribute('data-info', 'Company Leave: ' + companyLeave.reason); // Display the reason

                            // Overwrite employee leave or attendance if it's a company leave
                            let employeeLeave = employeeLeaves.find(item => item.leave_date === dateStr);
                            if (employeeLeave) {
                                cell.classList.remove('employee-leave'); // Remove employee leave
                                cell.setAttribute('data-info', 'Company Leave: ' + companyLeave
                                    .reason); // Overwrite with company leave
                            }

                            // Mark as company leave, no need to check employee attendance if company leave exists
                            attendedDates = attendedDates.filter(date => date !== dateStr);
                        }

                        // Check for employee leaves and add leave type
                        if (!companyLeave) { // Only check if it's not a company leave
                            let employeeLeave = employeeLeaves.find(item => item.leave_date === dateStr);
                            if (employeeLeave) {
                                cell.classList.add('employee-leave');
                                cell.setAttribute('data-info', 'Employee Leave: ' + employeeLeave
                                    .leave_type); // Display the leave type (CL, EL, etc.)
                            }
                        }

                        // Mark weekends (Sundays, Saturdays off)
                        if (weeklyOffs.includes(date.getDay())) {
                            cell.classList.add('week-off');
                            cell.setAttribute('data-info', 'Weekly Off');
                        }

                        if (isSaturdayOff(date, saturdayCount)) {
                            cell.classList.add('week-off');
                            cell.setAttribute('data-info', 'Weekly Off');
                        }

                        // Mark attended dates
                        if (attendedDates.includes(dateStr)) {
                            cell.classList.add('attended');
                            cell.setAttribute('data-info', 'Attended');
                        }

                        // Increment Saturday count if the day is Saturday
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

                function createCell(content = '') {
                    let cell = document.createElement('div');
                    cell.textContent = content;

                    return cell;
                }

                // Function to check if it's a Saturday Off
                function isSaturdayOff(date, saturdayCount) {
                    if (date.getDay() === 6) { // Saturday
                        if (saturdayOffs === 'all') {
                            return true; // Mark all Saturdays
                        }
                        // If it's the 2nd or 4th Saturday of the month
                        if (saturdayOffs.includes(saturdayCount)) {
                            return true;
                        }
                    }
                    return false;
                }
            </script> --}}

            {{-- <script>
                let select_month = document.getElementById('select_month');
                let select_year = document.getElementById('select_year');
                let btn_prev = document.getElementById('prev_month');
                let btn_next = document.getElementById('next_month');
                let btn_curr = document.getElementById('curr_month');
                let calendar_dates = document.getElementById('dates');

                let calendarData = {
                    companyLeaves: [],
                    employeeLeaves: [],
                    attendedDates: []
                };

                // Fetch data for the selected month and year
                function fetchCalendarData(year, month) {
                    return new Promise((resolve, reject) => {
                        $.ajax({
                            url: '/attendance/data', // Adjust as per route
                            method: 'GET',
                            data: {
                                year: year,
                                month: month + 1 // Backend expects 1-based month
                            },
                            success: function(response) {
                                calendarData.companyLeaves = response.company_leaves;
                                calendarData.employeeLeaves = response.employee_leaves;
                                calendarData.attendedDates = response.attended_dates;
                                resolve();
                            },
                            error: function(error) {
                                console.error('Error fetching calendar data:', error);
                                reject(error);
                            }
                        });
                    });
                }

                // Initial setup for the current month and year
                const today = new Date();
                let currentYear = today.getFullYear();
                let currentMonth = today.getMonth();

                // Initial fetch and calendar generation
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
                    fetchCalendarData(currentYear, currentMonth).then(() => {
                        generateDates();
                    });
                });

                // Handle month or year change
                function onMonthChange() {
                    currentYear = parseInt(select_year.value);
                    currentMonth = parseInt(select_month.value);
                    fetchCalendarData(currentYear, currentMonth).then(() => {
                        markDates();
                    });
                }

                // Switch month and fetch new data
                function switchMonth(dir) {
                    let newDate = new Date(currentYear, currentMonth + dir, 1);
                    currentYear = newDate.getFullYear();
                    currentMonth = newDate.getMonth();

                    fetchCalendarData(currentYear, currentMonth).then(() => {
                        generateDates();
                    });
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
                    for (let day = 1; day <= daysInMonth; day++) {
                        calendar_dates.append(createCell(day));
                    }

                    // Mark special dates
                    markDates();
                }

                // Mark special dates on the calendar
                function markDates() {
                    const cells = calendar_dates.children;

                    Array.from(cells).forEach((cell) => {
                        let day = parseInt(cell.textContent);
                        if (!day) return;

                        let dateStr =
                            `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                        let leave = calendarData.companyLeaves.find(item => item.leave_date === dateStr);
                        let employeeLeave = calendarData.employeeLeaves.find(item => item.leave_date === dateStr);
                        let attended = calendarData.attendedDates.includes(dateStr);

                        cell.className = ''; // Reset classes
                        cell.setAttribute('data-info', ''); // Reset tooltips

                        if (leave) {
                            cell.classList.add('company-leave');
                            cell.setAttribute('data-info', `Company Leave: ${leave.reason}`);
                        } else if (employeeLeave) {
                            cell.classList.add('employee-leave');
                            cell.setAttribute('data-info', `Employee Leave: ${employeeLeave.leave_type}`);
                        } else if (attended) {
                            cell.classList.add('attended');
                            cell.setAttribute('data-info', 'Attended');
                        }
                    });
                }

                // Create a calendar cell
                function createCell(content = '') {
                    let cell = document.createElement('div');
                    cell.textContent = content;
                    return cell;
                }
            </script> --}}


            <script>
                let select_month = document.getElementById('select_month');
                let select_year = document.getElementById('select_year');
                let btn_prev = document.getElementById('prev_month');
                let btn_next = document.getElementById('next_month');
                let btn_curr = document.getElementById('curr_month');
                let calendar_dates = document.getElementById('dates');

                let calendarData = {
                    companyLeaves: [],
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
                    return new Promise((resolve, reject) => {
                        $.ajax({
                            url: '/attendance/data', // Adjust as per route
                            method: 'GET',
                            data: {
                                year: year,
                                month: month + 1 // Backend expects 1-based month
                            },
                            success: function(response) {
                                calendarData.employeeLeaves = response.employee_leaves;
                                calendarData.attendedDates = response.attended_dates;
                                calendarData.companyLeaves = response.company_leaves;
                                console.log(response);

                                resolve();
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

                        // Check for employee leaves
                        let employeeLeave = calendarData.employeeLeaves.find(item => item.leave_date === dateStr);
                        if (employeeLeave) {
                            cell.classList.add('employee-leave');
                            cell.setAttribute('data-info', `Absent: ${employeeLeave.leave_type}`);
                        }

                        // Check for attendance
                        if (calendarData.attendedDates.includes(dateStr)) {
                            cell.classList.add('attended');
                            cell.setAttribute('data-info', 'Attended');
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




    </body>

    </html>
</x-app-layout>
