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

            #calendar #dates div.company-leave {
                background-color: lightcoral;
                color: white;
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
        <div id="calendar">

            <div class="color-indicator">
                <div>
                    <span style="background-color: lightcoral;"></span> Company Leave
                </div>
                <div>
                    <span style="background-color: lightblue;"></span> Weekly Off
                </div>
                <div>
                    <span style="background-color: orange;"></span> Employee Leave
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

        <script>
            let select_month = document.getElementById('select_month');
            let select_year = document.getElementById('select_year');
            let btn_prev = document.getElementById('prev_month');
            let btn_next = document.getElementById('next_month');
            let btn_curr = document.getElementById('curr_month');
            let calendar_dates = document.getElementById('dates');
            let today = new Date();

            // Example data
            const companyLeaves = ['2023-12-25', '2023-12-31'];
            const weeklyOffs = [0]; // Sundays
            const saturdayOffs = [1, 3]; // 2nd and 4th Saturday, or 'all' for all Saturdays
            const employeeLeaves = ['2023-12-15', '2023-12-20'];
            const attendedDates = ['2023-12-10', '2023-12-12'];

            // Set current month and year
            select_year.value = today.getFullYear();
            select_month.value = today.getMonth();
            generateDates();

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
                    let date = new Date(year, month, day);
                    let dateStr = date.toISOString().split('T')[0];
                    let cell = createCell(day);

                    // Mark special dates
                    if (dateStr === today.toISOString().split('T')[0]) {
                        cell.classList.add('today');
                        cell.setAttribute('data-info', 'Today');
                    }
                    if (companyLeaves.includes(dateStr)) {
                        cell.classList.add('company-leave');
                        cell.setAttribute('data-info', 'Company Leave');
                    }
                    if (weeklyOffs.includes(date.getDay())) {
                        cell.classList.add('week-off');
                        cell.setAttribute('data-info', 'Weekly Off');
                    }
                    if (isSaturdayOff(date, saturdayCount)) {
                        cell.classList.add('week-off');
                        cell.setAttribute('data-info', 'Weekly Off');
                    }
                    if (employeeLeaves.includes(dateStr)) {
                        cell.classList.add('employee-leave');
                        cell.setAttribute('data-info', 'Employee Leave');
                    }
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
        </script>
    </body>

    </html>
</x-app-layout>
