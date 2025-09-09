window.addEventListener('load', init)

function init() {
    console.log('Hello, world!')
    togglePlayPause();
    handleLikes();
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
