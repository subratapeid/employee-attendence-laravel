document.addEventListener('DOMContentLoaded', () => {
    // Fetch and render duties on page load
    fetchDuties('/activity');

    // Add event listener to the filter button
    document.querySelector('.btn-primary').addEventListener('click', function () {
        const month = document.querySelector('.dropdown-container select:nth-child(1)').value;
        const year = document.querySelector('.dropdown-container select:nth-child(2)').value;

        // Build query string for filter
        const url = `/activity?month=${month}&year=${year}`;
        fetchDuties(url);
    });
});

// Populate dropdown options dynamically
function populateDropdown(selector, options) {
    const dropdown = document.querySelector(selector);
    dropdown.innerHTML = ''; // Clear existing options

    options.forEach(option => {
        const optionElement = document.createElement('option');
        optionElement.value = option.value || option; // Use `value` if provided
        optionElement.textContent = option.label || option; // Use `label` if provided
        dropdown.appendChild(optionElement);
    });
}

// Function to fetch and render duties
function fetchDuties(url) {
    showLoader(true);

    fetch(url)
        .then(response => response.json())
        .then(data => {
            renderDuties(data);
        })
        .catch(error => {
            console.error('Error fetching duties:', error);
        })
        .finally(() => {
            showLoader(false);
        });
}

// Function to render duties
function renderDuties(duties) {
    const dutyContainer = document.querySelector('.duty-card-container');
    if (!dutyContainer) {
        console.error('Error: .duty-card-container not found in the DOM.');
        return;
    }

    dutyContainer.innerHTML = ''; // Clear previous cards

    if (duties.length === 0) {
        dutyContainer.innerHTML = '<div class="no-records">No records found</div>';
        return;
    }

    duties.forEach(duty => {
        const dutyCard = `
            <div class="duty-card">
                <div class="duty-label">
                ${formatDutyDate(duty.start_timestamp)}<br>${duty.duration}
                </div>
                <div class="duty-header">
                    <div class="duty-section">
                        <img src="${duty.start_photo}" alt="Start Profile" />
                        <div class="ms-3">
                            <h4 class="duty-start-label">Duty Start</h4>
                            <div>Timestamp: <span class="end-date">${duty.start_timestamp}</span></div>
                            <div>Location: <span class="end-location">${duty.start_location}</span></div>
                            <div>Disparity: <span class="start-disparity">${duty.start_disparity}</span></div>
                        </div>
                    </div>
                    <div class="duty-section">
                        <img src="${duty.end_photo || 'assets/img/placeholder.jpg'}" alt="End Profile" />
                        <div class="ms-3">
                            <h4 class="duty-end-label">Duty End</h4>
                            <div>Timestamp: <span class="end-date">${duty.end_timestamp}</span></div>
                            <div>Location: <span class="end-location">${duty.end_location}</span></div>
                            <div>Disparity: <span class="end-disparity">${duty.end_disparity}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        dutyContainer.insertAdjacentHTML('beforeend', dutyCard);
    });
}

function formatDutyDate(timestamp) {
    const [datePart] = timestamp.split(' '); // Get the date part (e.g., "18-01-2025")
    const [day, month, year] = datePart.split('-'); // Split into day, month, and year
    const date = new Date(`${year}-${month}-${day}`); // Create a JavaScript Date object

    // Get the day name (e.g., "Saturday")
    const dayName = date.toLocaleDateString('en-US', { weekday: 'short' });

    // Return formatted string
    return `${day} - ${dayName}`;
}

// Function to initialize dropdowns with available months and years
function initializeDropdowns() {
    fetch('/activity/available-options')
        .then(response => response.json())
        .then(data => {
            populateDropdown('.dropdown-container select:nth-child(1)', data.months);
            populateDropdown('.dropdown-container select:nth-child(2)', data.years);
        })
        .catch(error => {
            console.error('Error fetching dropdown data:', error);
        });
}
initializeDropdowns();

// Function to show/hide loader animation
function showLoader(show) {
    const loader = document.querySelector('.loader');
    if (loader) {
        loader.style.display = show ? 'block' : 'none';
    }
}
