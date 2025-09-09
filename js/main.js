window.addEventListener('load', init)

function init() {
    console.log('Hello, world!')
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

                const shareUrl = `${window.location.origin}${window.location.pathname}#${siteTitle}-${videoId}`;

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
    const hash = window.location.hash.substring(1); // e.g., "Meticulous-video-1"
    if (hash) {
        try {
            // Extract the video ID from the hash
            const videoId = hash.substring(hash.indexOf('-') + 1); // e.g., "video-1"
            const videoToScroll = document.getElementById(videoId);

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