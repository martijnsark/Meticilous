window.addEventListener('load', init)

function init() {
    createEventListeners();
    trackCurrentVideo();
    togglePlayPause();
    handleLikes();
    handleSharing();
    scrollToVideoFromUrl();
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
            console.log('pausing', video.closest('.video').id);
        }
    });
    // play the current video
    const currentVideo = document.getElementById(id).querySelector('video');
    if (currentVideo.paused) {
        currentVideo.play();
        console.log('playing', id);
    }

    if (id === 'video-3') {
        showDialog();
    }
}

function createEventListeners() {
    const dialog = document.querySelector('dialog');
    const buttons = dialog.querySelectorAll('button');

    buttons[0].addEventListener('click', () => handleDialogButtons(false));
    buttons[1].addEventListener('click', () => handleDialogButtons(true));
}

function showDialog() {
    const dialog = document.querySelector('dialog');

    if (localStorage.getItem('permissionsGranted') === 'true') {
        return; // Permissions already granted, do not show dialog
    }
    dialog.showModal();
}

function handleDialogButtons(bool) {
    console.log(bool)
    const dialog = document.querySelector('dialog');
    const buttons = dialog.querySelectorAll('button');

    if (bool) {
        dialog.close();
        alert('Showing permissions...');
        localStorage.setItem('permissionsGranted', 'true');
    } else {
        dialog.close();
        alert('You have declined the permissions. Some features may not work properly.');
    }
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