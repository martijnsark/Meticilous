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
        // Check if the button is a like button
        if (icon && (icon.textContent.trim() === 'favorite_border' || icon.textContent.trim() === 'favorite')) {
            button.addEventListener('click', () => {
                const likeCountElement = button.querySelector('p');
                let likeCount = parseInt(likeCountElement.textContent);

                if (icon.textContent.trim() === 'favorite_border') {
                    icon.textContent = 'favorite';
                    likeCount++;
                } else {
                    icon.textContent = 'favorite_border';
                    likeCount--;
                }
                likeCountElement.textContent = likeCount;
            });
        }
    });
}

