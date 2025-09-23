const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const snapshot = document.getElementById('snapshot');
const captureBtn = document.getElementById('capture');

// 🔹 1. Vraag toestemming en start de camera
async function startCamera() {
    try {
        const stream = await navigator.mediaDevices.getUserMedia({ video: true });
        video.srcObject = stream;
    } catch (err) {
        console.error('Camera-toegang geweigerd of niet beschikbaar', err);
        // alert('Kan camera niet openen. Controleer je instellingen.');
    }
}

// 🔹 2. Maak een foto
captureBtn.addEventListener('click', () => {
    // canvas krijgt zelfde grootte als video
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    const ctx = canvas.getContext('2d');
    ctx.drawImage(video, 0, 0);

    // Zet om naar een data-URL (base64) of blob
    const dataURL = canvas.toDataURL('image/png');
    snapshot.src = dataURL;
    snapshot.style.display = 'block';

    // Optioneel: dataURL naar server sturen via fetch
});

startCamera();
