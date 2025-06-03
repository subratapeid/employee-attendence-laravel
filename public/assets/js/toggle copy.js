document.addEventListener('DOMContentLoaded', () => {
    const toggleInput = document.getElementById('toggle');
    const onDutyPopup = document.getElementById('on-duty-popup');
    const offDutyPopup = document.getElementById('off-duty-popup');
    const onDutyForm = document.getElementById('on-duty-form');
    const offDutyForm = document.getElementById('off-duty-form');
    const onDutyClose = document.getElementById('on-duty-close');
    const offDutyClose = document.getElementById('off-duty-close');

    toggleInput.addEventListener('change', (event) => {
        if (event.target.checked) {
            // Show On-Duty popup
            toggleInput.checked = false; // Prevent toggling ON immediately
            onDutyPopup.classList.add('visible');
            // openCaptureModal();
        } else {
            // Show Off-Duty popup
            toggleInput.checked = true; // Prevent toggling OFF immediately
            offDutyPopup.classList.add('visible');
        }
    });

    // Handle On-Duty form submission
    onDutyForm.addEventListener('submit', (event) => {
        event.preventDefault();
        onDutyPopup.classList.remove('visible');
        toggleInput.checked = true; // Toggle to ON after submission
        alert('You are now On Duty!');
    });

    // Handle Off-Duty form submission
    offDutyForm.addEventListener('submit', (event) => {
        event.preventDefault();
        offDutyPopup.classList.remove('visible');
        toggleInput.checked = false; // Toggle to OFF after submission
        alert('You are now Off Duty!');
    });

    // Close the popup on clicking the close button
    onDutyClose.addEventListener('click', () => {
        onDutyPopup.classList.remove('visible');
        // stopCamera();

    });

    offDutyClose.addEventListener('click', () => {
        offDutyPopup.classList.remove('visible');
        // stopCamera();

    });

    // Close popup on clicking outside the content
    [onDutyPopup, offDutyPopup].forEach((popup) => {
        popup.addEventListener('click', (event) => {
            if (event.target === popup) {
                popup.classList.remove('visible');
                // stopCamera();

            }
        });
    });
});
