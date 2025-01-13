// document.addEventListener('DOMContentLoaded', () => {
const toggleInput = document.getElementById('toggle');
const cameraPopup = document.getElementById('camera-popup');
const popupClose = document.getElementById('popup-close');

toggleInput.addEventListener('change', (event) => {
    if (event.target.checked) {
        // Show On-Duty popup
        toggleInput.checked = false; // Prevent toggling ON immediately
        openCaptureModal('on');
    } else {
        // Show Off-Duty popup
        toggleInput.checked = true; // Prevent toggling OFF immediately
        openCaptureModal('off');
    }
});

// // Handle On-Duty form submission
// onDutyForm.addEventListener('submit', (event) => {
//     event.preventDefault();
//     onDutyPopup.classList.remove('visible');
//     toggleInput.checked = true; // Toggle to ON after submission
//     // alert('You are now On Duty!');
// });

// // Handle Off-Duty form submission
// offDutyForm.addEventListener('submit', (event) => {
//     event.preventDefault();
//     offDutyPopup.classList.remove('visible');
//     toggleInput.checked = false; // Toggle to OFF after submission
//     // alert('You are now Off Duty!');
// });

// Close the popup on clicking the close button
popupClose.addEventListener('click', () => {
    cameraPopup.classList.remove('visible');
    stopCamera();

});


// Close popup on clicking outside the content
[cameraPopup].forEach((popup) => {
    popup.addEventListener('click', (event) => {
        if (event.target === popup) {
            popup.classList.remove('visible');
            stopCamera();
        }
    });
});
// });
