const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const captureBtn = document.getElementById('captureBtn');
const retakeBtn = document.getElementById('retakeBtn');
const confirmBtn = document.getElementById('confirmBtn');
const capturedPhoto = document.getElementById('capturedPhoto');
const popupTitle = document.getElementById('popupTitle');

let currentFacingMode = 'user';
let stream;
let currentLatitude = null;
let currentLongitude = null;
let currentPhotoType = null;

function startCamera() {
    const constraints = { video: { facingMode: currentFacingMode } };
    navigator.mediaDevices.getUserMedia(constraints)
        .then(function (mediaStream) {
            stream = mediaStream;
            video.srcObject = stream;
            video.play().then(() => {
                console.log('Camera stream started successfully.');
            }).catch(function (err) {
                console.error('Error playing video: ', err);
            });
        }).catch(function (err) {
            console.error('Error accessing media devices.', err);
            handlePermissionDenied();
        });
}

function handlePermissionDenied() {
    captureBtn.disabled = true;
    retakeBtn.disabled = true;
    confirmBtn.disabled = true;
    const container = document.getElementById('permission-message');
    const video = document.getElementById('video');
    video.style.display = 'none';
    container.innerHTML = '';
    const gif = document.createElement('img');
    gif.src = 'assets/img/access-denied.png';
    gif.alt = 'Permission Denied';
    container.appendChild(gif);
}

function stopCamera() {
    if (stream) {
        const tracks = stream.getTracks();
        tracks.forEach(function (track) {
            track.stop();
        });
        stream = null;
    }
}
function openCaptureModal(type) {
    currentPhotoType = type;
    currentFacingMode = 'user';
    cameraPopup.classList.add('visible');
    retakeBtn.classList.add('d-none');
    confirmBtn.classList.add('d-none');
    if (type == 'on') {
        popupTitle.textContent = 'Go On Duty';
        confirmBtn.textContent = 'On Duty';
    } else {
        popupTitle.textContent = 'Go Off Duty';
        confirmBtn.textContent = 'Off Duty';
    }
    captureBtn.classList.remove('d-none');
    if (!stream) startCamera();
    video.style.display = 'block';
    capturedPhoto.classList.add('d-none');
    canvas.style.display = 'none';
};

// captureBtn.addEventListener('click', function () {
//     // toggleCameraBtn.classList.add('d-none');
//     captureBtn.classList.add('d-none');
//     retakeBtn.classList.remove('d-none');
//     confirmBtn.classList.remove('d-none');
//     confirmBtn.disabled = true;

//     const context = canvas.getContext('2d');
//     canvas.width = video.videoWidth;
//     canvas.height = video.videoHeight;
//     context.drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
//     const now = new Date(); // Get the current local date and time
//     console.log(now);

//     const dateOptions = { year: 'numeric', month: 'short', day: 'numeric' };
//     const timeOptions = { hour: 'numeric', minute: 'numeric', hour12: true };

//     const formattedDate = now.toLocaleDateString('en-IN', dateOptions);
//     const formattedTime = now.toLocaleTimeString('en-IN', timeOptions);

//     drawOnCanvas(formattedDate, formattedTime);
// });


captureBtn.addEventListener('click', function () {
    // toggleCameraBtn.classList.add('d-none');
    captureBtn.classList.add('d-none');
    retakeBtn.classList.remove('d-none');
    confirmBtn.classList.remove('d-none');
    confirmBtn.disabled = true;

    const context = canvas.getContext('2d');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    context.drawImage(video, 0, 0, video.videoWidth, video.videoHeight);

    // Fetch current time from the backend
    fetch('/current-time')
        .then((response) => response.json())
        .then((data) => {
            const serverTime = new Date(data.current_time); // Parse server time
            // console.log("Server Time:", serverTime);

            const dateOptions = { year: 'numeric', month: 'short', day: 'numeric' };
            const timeOptions = { hour: 'numeric', minute: 'numeric', hour12: true };

            const formattedDate = serverTime.toLocaleDateString('en-IN', dateOptions);
            const formattedTime = serverTime.toLocaleTimeString('en-IN', timeOptions);

            drawOnCanvas(formattedDate, formattedTime);
        })
        .catch((error) => {
            console.error("Error fetching server time:", error);
        });
});


function drawOnCanvas(dateString, timeString) {
    const context = canvas.getContext('2d');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    context.drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
    navigator.geolocation.getCurrentPosition(position => {
        const { latitude, longitude } = position.coords;
        currentLatitude = latitude; // Store latitude globally
        currentLongitude = longitude; // Store longitude globally
        const rectHeight = 50;
        context.globalAlpha = 0.5;
        context.fillStyle = 'black';
        context.fillRect(0, canvas.height - rectHeight, canvas.width, rectHeight);
        context.globalAlpha = 1.0;
        context.fillStyle = 'white';
        context.font = '16px Arial';
        context.fillText(`Date: ${dateString} Time: ${timeString}`, 10, canvas.height - rectHeight + 20);
        context.fillText(`Latitude: ${latitude.toFixed(6)}, Longitude: ${longitude.toFixed(6)}`, 10, canvas.height - rectHeight + 40);
        displayCapturedPhoto();
    });
}

function displayCapturedPhoto() {
    stopCamera();
    const photoDataUrl = canvas.toDataURL('image/png');
    video.style.display = 'none';
    capturedPhoto.src = photoDataUrl;
    capturedPhoto.classList.remove('d-none');
    canvas.classList.add('d-none');
    confirmBtn.disabled = false;

}

retakeBtn.addEventListener('click', function () {
    if (!stream) startCamera();
    video.style.display = 'block';
    capturedPhoto.classList.add('d-none');
    captureBtn.classList.remove('d-none');
    retakeBtn.classList.add('d-none');
    confirmBtn.classList.add('d-none');
});

// confirmBtn.addEventListener('click', function () {
//     const photoDataUrl = canvas.toDataURL('image/png');
//     const photoDataBase64 = photoDataUrl.replace(/^data:image\/(png|jpg);base64,/, "");

//     // console.log(photoDataBase64);
//     console.log(currentLatitude);
//     console.log(currentLongitude);
//     console.log(currentPhotoType);
//     cameraPopup.classList.remove('visible');
//     if (currentPhotoType == 'on') {
//         toggleInput.checked = true;
//     } else {
//         toggleInput.checked = false;
//     }
// });


confirmBtn.addEventListener('click', function () {
    confirmBtn.disabled = 'true';
    confirmBtn.textContent = 'Updating..';
    const photoDataUrl = canvas.toDataURL('image/png');
    const photoDataBase64 = photoDataUrl.replace(/^data:image\/(png|jpg);base64,/, "");

    const requestData = {
        latitude: currentLatitude,
        longitude: currentLongitude,
        photo: photoDataBase64,
        type: currentPhotoType, // 'on' or 'off'
        datetime: new Date().toISOString(),
        _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    };

    // Send data to the backend
    $.ajax({
        url: '/duty-status',
        type: 'POST',
        data: requestData,
        success: function (response) {
            toastr.success('Duty Status Updated Successfully!', 'Status Updated');
            console.log(response.message);
            // Close the camera popup after success
            cameraPopup.classList.remove('visible');
            // Update the toggle state and local storage
            toggleInput.checked = currentPhotoType === 'on';
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
            alert('An error occurred while updating duty status.');
        }
    });

});

// // On page load, fetch the current state
// document.addEventListener('DOMContentLoaded', function () {
//     const storedStatus = localStorage.getItem('dutyStatus');

//     if (storedStatus) {
//         // Use stored status for immediate display
//         toggleInput.checked = storedStatus === 'on';
//     }

//     // Fetch the latest state from the server
//     $.ajax({
//         url: '/duty-status',
//         type: 'GET',
//         success: function (response) {
//             toggleInput.checked = response.type === 'on';
//             console.log(response);

//             // Update local storage with the latest status
//             localStorage.setItem('dutyStatus', response.type);
//         },
//         error: function (xhr, status, error) {
//             console.error(xhr.responseText);
//         }
//     });
// });




// JavaScript Logic

document.addEventListener('DOMContentLoaded', function () {
    const toggleInput = document.getElementById('toggle'); // Correct input ID

    // Fetch the latest state from the server
    $.ajax({
        url: '/duty-status',
        type: 'GET',
        success: function (response) {
            console.log(response);

            if (response.type === 'unresolved') {
                // Show the popup for unresolved duty
                showUnresolvedDutyPopup(response.unresolved_duty);
            } else {
                // Update the toggle based on the current status
                toggleInput.checked = response.type === 'on';

            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});

// Function to show the unresolved duty popup
function showUnresolvedDutyPopup(unresolvedDuty) {
    // Create the popup HTML
    const popup = document.createElement('div');
    popup.id = 'unresolvedDutyPopup';
    popup.classList.add('popup-overlay'); // Optional CSS class for styling
    popup.innerHTML = `
        <div class="unresolved-popup-content">
            <h2>Unresolved Duty</h2>
            <p class="mb-1">You have an unresolved duty on </br><strong>${unresolvedDuty.created_at}</strong>.</p>
            <p class="mt-1 mb-1"><img src="${unresolvedDuty.start_photo}" alt="Start Photo" style="max-width: 100%;"></p>

            <form id="resolveDutyForm">
                <label for="manualLogoutTime">Enter Logout Time</label>
                <div class="custom-time-input mt-2 mb-1" id="manualLogoutTime">
                    <!-- Hour Dropdown -->
                    <select id="hours" class="time-dropdown" name="hours">
                        <option value="" disabled selected>Hour</option>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>

                    <!-- Minutes Dropdown -->
                    <select id="minutes" class="time-dropdown" name="minutes">
                        <option value="" disabled selected>Minutes</option>
                        <option value="00">00</option>
                        <option value="15">15</option>
                        <option value="30">30</option>
                        <option value="45">45</option>
                    </select>

                    <!-- AM/PM Dropdown -->
                    <select id="ampm" class="time-dropdown" name="ampm">
                        <option value="" disabled selected>AM/PM</option>
                        <option value="AM">AM</option>
                        <option value="PM">PM</option>
                    </select>
                </div>
                <div class"mt-1">
                <label for="remarks">Enter your remarks</label>
                <textarea id="remarks" name="remarks" rows="2" style="width: 100%;" class="mt-1"></textarea> 
                </div>
                <button type="submit" id="submit-btn" class="submit-btn">Submit</button>
                <div id="spinner" class="spinner" style="display:none;"></div>
            </form>
        </div>
    `;

    // Append the popup to the body
    document.body.appendChild(popup);

    const timeform = document.getElementById('resolveDutyForm');
    const submitBtn = document.getElementById('submit-btn');
    const spinner = document.getElementById('spinner');

    timeform.addEventListener('submit', function (event) {
        event.preventDefault();

        // Get values from dropdowns
        const hour = document.getElementById('hours').value;
        const minutes = document.getElementById('minutes').value;
        const ampm = document.getElementById('ampm').value;

        // Validate if all dropdowns are selected
        if (!hour || !minutes || !ampm) {
            alert('Please select all fields: Hour, Minutes, and AM/PM.');
            return;
        }

        // Format the time to HH:mm AM/PM format
        const manualLogoutTime = `${hour}:${minutes} ${ampm}`;

        // Disable the submit button and show the spinner
        submitBtn.disabled = true;
        submitBtn.innerText = 'Submitting...';
        spinner.style.display = 'block';

        // Get latitude and longitude using Geolocation API
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function (position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    // Send AJAX request with time and location data
                    $.ajax({
                        url: '/resolve-duty',
                        type: 'POST',
                        data: {
                            manual_logout_time: manualLogoutTime,
                            latitude: latitude,
                            longitude: longitude,
                            type: 'off',
                            _token: document.querySelector('meta[name="csrf-token"]').content, // CSRF token for security
                        },
                        success: function (response) {
                            alert(response.message);
                            // Remove the popup
                            document.body.removeChild(popup);
                            // Reload the page or update the status
                            location.reload();
                        },
                        error: function (xhr, status, error) {
                            alert('Error: ' + xhr.responseJSON.message);
                        },
                        complete: function () {
                            // Enable the button and hide the spinner
                            submitBtn.disabled = false;
                            submitBtn.innerText = 'Submit';
                            spinner.style.display = 'none';
                        }
                    });
                },
                function (error) {
                    console.log(error.message);
                    alert('Geolocation error: Unable To Get Your Location');
                    submitBtn.disabled = false;
                    submitBtn.innerText = 'Submit';
                    spinner.style.display = 'none';
                }
            );
        } else {
            alert('Geolocation is not supported by your browser.');
            submitBtn.disabled = false;
            submitBtn.innerText = 'Submit';
            spinner.style.display = 'none';
        }
    });
}



