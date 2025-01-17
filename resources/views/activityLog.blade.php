<x-app-layout>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Activity Log</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f5f5f5;
            }

            .activity-log {
                max-width: 400px;
                margin: 20px auto;
                background: #fff;
                border-radius: 10px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
                overflow: hidden;
            }

            header {
                display: flex;
                justify-content: space-between;
                padding: 10px;
                background-color: #ff5252;
                color: #fff;
            }

            header .tab,
            header .refresh {
                flex: 1;
                text-align: center;
                padding: 10px;
                border: none;
                font-size: 14px;
                cursor: pointer;
                background: none;
                color: #fff;
            }

            header .tab.active {
                background: #fff;
                color: #ff5252;
                border-radius: 5px;
            }

            header .refresh {
                border-radius: 5px;
                background: #fff;
                color: #ff5252;
            }

            .log-entries {
                padding: 10px;
            }

            .log-entry {
                display: flex;
                justify-content: space-between;
                background: #f9f9f9;
                padding: 10px;
                margin: 10px 0;
                border-radius: 5px;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            }

            .date {
                text-align: center;
            }

            .date .day {
                font-size: 20px;
                font-weight: bold;
                color: #ff5252;
            }

            .date .weekday {
                font-size: 12px;
                color: #333;
            }

            .details {
                flex: 1;
                padding: 0 10px;
            }

            .details p {
                margin: 3px 0;
            }

            .status {
                font-weight: bold;
                display: inline-block;
                padding: 2px 5px;
                border-radius: 5px;
                color: #fff;
            }

            .status.in {
                background: #27ae60;
            }

            .status.out {
                background: #e74c3c;
            }

            .meta {
                font-size: 12px;
                color: #555;
            }

            .status-indicator {
                text-align: center;
            }

            .status-indicator p {
                font-size: 12px;
                margin: 5px 0;
                color: #27ae60;
            }

            .status-indicator .checkmark {
                font-size: 18px;
                color: #27ae60;
            }
        </style>
    </head>

    <body>
        <div class="activity-log">
            <header>
                <button class="tab active">OCTOBER</button>
                <button class="tab">NOVEMBER</button>
                <button class="refresh">REFRESH</button>
            </header>

            <div class="log-entries">
                <!-- Log Entry 1 -->
                <div class="log-entry">
                    <div class="date">
                        <p class="day">06</p>
                        <p class="weekday">WED</p>
                    </div>
                    <div class="details">
                        <p><strong>606005</strong></p>
                        <p>PANKAJ KUMAR SINGH</p>
                        <p class="status in">IN</p>
                        <div class="meta">
                            <p>Shift: D</p>
                            <p>Post: Reception_12_12_5</p>
                            <p>Rank: SUPERVISOR</p>
                        </div>
                    </div>
                    <div class="status-indicator">
                        <p>SUCCESS</p>
                        <span class="checkmark">✔</span>
                    </div>
                </div>

                <!-- Log Entry 2 -->
                <div class="log-entry">
                    <div class="date">
                        <p class="day">05</p>
                        <p class="weekday">TUE</p>
                    </div>
                    <div class="details">
                        <p><strong>606005</strong></p>
                        <p>PANKAJ KUMAR SINGH</p>
                        <p class="status in">IN</p>
                        <div class="meta">
                            <p>Shift: D</p>
                            <p>Post: Reception_12_12_5</p>
                            <p>Rank: SUPERVISOR</p>
                        </div>
                    </div>
                    <div class="status-indicator">
                        <p>SUCCESS</p>
                        <span class="checkmark">✔</span>
                    </div>
                </div>

                <!-- Log Entry 3 -->
                <div class="log-entry">
                    <div class="date">
                        <p class="day">04</p>
                        <p class="weekday">MON</p>
                    </div>
                    <div class="details">
                        <p><strong>606005</strong></p>
                        <p>PANKAJ KUMAR SINGH</p>
                        <p class="status out">OUT</p>
                        <div class="meta">
                            <p>Shift: D</p>
                            <p>Post: Reception_12_12_5</p>
                            <p>Rank: SUPERVISOR</p>
                        </div>
                    </div>
                    <div class="status-indicator">
                        <p>SUCCESS</p>
                        <span class="checkmark">✔</span>
                    </div>
                </div>
            </div>
        </div>


        <script>
            const activities = [{
                    date: '16 Jan 2025',
                    time: '06:55:33',
                    name: 'PANKAJ KUMAR SINGH',
                    status: 'IN',
                    shift: 'D',
                    post: 'Reception_12_12_5',
                    rank: 'SUPERVISOR'
                },
                {
                    date: '15 Jan 2025',
                    time: '19:07:30',
                    name: 'PANKAJ KUMAR SINGH',
                    status: 'OUT',
                    shift: 'D',
                    post: 'Reception_12_12_5',
                    rank: 'SUPERVISOR'
                },
                {
                    date: '14 Jan 2025',
                    time: '06:50:33',
                    name: 'PANKAJ KUMAR SINGH',
                    status: 'IN',
                    shift: 'D',
                    post: 'Reception_12_12_5',
                    rank: 'SUPERVISOR'
                }
            ];

            const activityLog = document.getElementById('activity-log');

            activities.forEach(activity => {
                const card = document.createElement('div');
                card.classList.add('card');

                card.innerHTML = `
                    <div class="card-header">
                        <span class="date">${activity.date}</span>
                        <span class="time">${activity.time}</span>
                    </div>
                    <div class="card-body">
                        <p><strong>${activity.name}</strong></p>
                        <p>Shift: ${activity.shift}</p>
                        <p>Post: ${activity.post}</p>
                        <p>Rank: ${activity.rank}</p>
                        <span class="status ${activity.status.toLowerCase()}">${activity.status}</span>
                    </div>
                `;

                activityLog.appendChild(card);
            });
        </script>
    </body>

    </html>

</x-app-layout>
