window.addEventListener('load', init)

function init() {
    audioSlider();
}

function audioSlider() {
    const volumeSlider = document.getElementById('volume-slider');
    const volumeValue = document.getElementById('volume-value');
    const storageKey = 'volumeLevel';

    // Function to update slider's visual state
    const updateSlider = (value) => {
        volumeValue.textContent = `${value}%`;
        volumeSlider.style.setProperty('--background-size', `${value}%`);
        volumeSlider.value = value;
    };

    // Load saved volume from localStorage when the page loads
    const savedVolume = localStorage.getItem(storageKey);
    if (savedVolume !== null) {
        updateSlider(savedVolume);
    } else {
        // Set initial state if no value is saved
        updateSlider(volumeSlider.value);
    }

    // Save volume to localStorage and update visuals when the slider is used
    volumeSlider.addEventListener('input', (event) => {
        const value = event.target.value;
        updateSlider(value);
        localStorage.setItem(storageKey, value);
    });
}