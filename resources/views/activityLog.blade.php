<x-app-layout>
    <style>
        .duty-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            margin: 50px 0;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            position: relative;
        }

        .duty-card img {
            border-radius: 5%;
            width: 110px;
            height: 110px;
            object-fit: cover;
        }

        .duty-card .duty-header {
            display: flex;
            justify-content: left;
            gap: 50px;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .duty-card .duty-section {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            padding-top: 10px;
        }

        .duty-card .duty-section:last-child {
            margin-bottom: 0;
        }

        .dropdown-container {
            display: flex;
            gap: 10px;
        }

        .duty-label {
            position: absolute;
            top: -25px;
            left: 20px;
            color: #fff;
            background-color: #6e007c;
            border: 1px solid #ddd;
            padding: 5px 10px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            font-size: 0.8rem;
            font-weight: bold;
        }

        .duty-start-label {
            font-size: 20px;
            font-weight: bold;
            color: #019619;
            line-height: 7px;

        }

        .duty-end-label {
            font-size: 20px;
            font-weight: bold;
            color: #d80808;
            line-height: 7px;

        }

        @media (max-width: 768px) {
            .duty-card .duty-header {
                gap: 10px;
                flex-direction: column;
            }


        }
    </style>
    <style>
        .loader {
            text-align: center;
            margin: 20px 0;
        }

        .no-records {
            text-align: center;
            margin: 20px 0;
            font-size: 16px;
            color: #888;
        }
    </style>

    <div class="pagetitle">
        <h1>Activity Log</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Activity Log</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard">

        {{-- <div class="container mt-4"> --}}
        <div class="d-flex justify-content-center mb-3">
            <div class="dropdown-container">
                <select class="form-select" style="width: auto;">
                    <option selected>January</option>
                    <option>February</option>
                    <option>March</option>
                </select>
                <select class="form-select" style="width: auto;">
                    <option selected>2025</option>
                    <option>2024</option>
                    <option>2023</option>
                </select>
                <button class="btn btn-primary">Filter</button>

            </div>
            {{-- <button class="btn btn-warning">Export</button> --}}
        </div>

        <!-- Duty Card -->
        {{-- <div class="duty-card">
            <div class="duty-label">15-SUN</br>08 Hrs, 30 Min</div>
            <div class="duty-header">
                <div class="duty-section">
                    <img src="/storage/photos/user1-off-2025-01-15_16-51-22.jpg" alt="Profile">
                    <div class="ms-3">
                        <h4 class="duty-start-label">Duty Start</h4>
                        <div>Timestamp: <span class="end-date">18-01-2025 10:10 AM</span></div>
                        <div>Location: <span class="end-location">Bangalore, Karnataka</span></div>
                        <div>Disparity: <span class="end-disparity">1km</span></div>
                    </div>
                </div>

                <div class="duty-section">
                    <img src="/storage/photos/user1-off-2025-01-15_16-51-22.jpg" alt="Profile">
                    <div class="ms-3">
                        <h4 class="duty-end-label">Duty End</h4>
                        <div>Timestamp: <span class="end-date">18-01-2025 10:10 AM</span></div>
                        <div>Location: <span class="end-location">Bangalore, Karnataka</span></div>
                        <div>Disparity: <span class="end-disparity">1km</span></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="duty-card">
            <div class="duty-label">16-SUN</br>09 Hrs, 10 Min</div>
            <div class="duty-header">
                <div class="duty-section">
                    <img src="/storage/photos/user1-off-2025-01-15_16-51-22.jpg" alt="Profile">
                    <div class="ms-3">
                        <h4 class="duty-start-label">Duty Start</h4>
                        <div>Timestamp: <span class="end-date">18-01-2025 10:10 AM</span></div>
                        <div>Location: <span class="end-location">Bangalore, Karnataka</span></div>
                        <div>Disparity: <span class="end-disparity">1.3km</span></div>
                    </div>
                </div>

                <div class="duty-section">
                    <img src="/storage/photos/user1-off-2025-01-15_16-51-22.jpg" alt="Profile">
                    <div class="ms-3">
                        <h4 class="duty-end-label">Duty End</h4>
                        <div>Timestamp: <span class="end-date">18-01-2025 10:10 AM</span></div>
                        <div>Location: <span id="end-location">Bangalore, Karnataka</span></div>
                        <div>Disparity: <span id="end-accuracy" class="duty-accuracy">0.2km</span></div>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="loader" style="display: none;">Loading...</div>

        {{--  --}}
        <div class="duty-card-container"></div>
        <!-- More cards can be added -->
        </div>
        <script src="assets/js/activityLog.js"></script>
</x-app-layout>
