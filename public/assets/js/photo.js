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
    gif.src = 'assets/images/cameraAccess.gif';
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
    const now = new Date(); // Get the current local date and time

    const dateOptions = { year: 'numeric', month: 'short', day: 'numeric' };
    const timeOptions = { hour: 'numeric', minute: 'numeric', hour12: true };

    const formattedDate = now.toLocaleDateString('en-IN', dateOptions);
    const formattedTime = now.toLocaleTimeString('en-IN', timeOptions);

    drawOnCanvas(formattedDate, formattedTime);
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

confirmBtn.addEventListener('click', function () {
    const photoDataUrl = canvas.toDataURL('image/png');
    const photoDataBase64 = photoDataUrl.replace(/^data:image\/(png|jpg);base64,/, "");

    // console.log(photoDataBase64);
    console.log(currentLatitude);
    console.log(currentLongitude);
    console.log(currentPhotoType);
    cameraPopup.classList.remove('visible');
    if (currentPhotoType == 'on') {
        toggleInput.checked = true;
    } else {
        toggleInput.checked = false;
    }
});