let currentAudio = null;
let isPlaying = false;  
const seekSlider = document.getElementById('seek-slider');
const volumeSlider = document.getElementById('volume-slider');


function playAudio(track) {
    
    if (currentAudio && !currentAudio.paused) {
        currentAudio.pause();
    }

    
    currentAudio = new Audio(track);
    currentAudio.play().catch(error => {
        console.error("Error playing audio: ", error);
    });

    currentAudio.addEventListener('timeupdate', () => {
        if (currentAudio.duration) {
            seekSlider.value = (currentAudio.currentTime / currentAudio.duration) * 100;
        }
    });

    updatePlayPauseButton(true); 
}

document.querySelectorAll('.spotify-playlist .card .item').forEach(item => {
    item.addEventListener('click', function () {
        const audioSrc = item.getAttribute('data-audio');

        if (audioSrc) {
            playAudio(audioSrc);

            const trackTitle = document.getElementById('track-title');
            trackTitle.textContent = item.querySelector('h4').textContent;

            const popup = document.getElementById('music-popup');
            popup.style.display = 'block';
            popup.classList.remove('minimized'); 

            popup.classList.add('opening');
            setTimeout(() => {
                popup.classList.remove('opening');
            }, 400); 
        }
    });
});

document.getElementById('close-popup').addEventListener('click', () => {
    const popup = document.getElementById('music-popup');

    if (popup.classList.contains('minimized')) {
        popup.classList.remove('minimized');
    } else {
        popup.classList.add('minimized');
    }
});

volumeSlider.addEventListener('input', () => {
    if (currentAudio) {
        currentAudio.volume = volumeSlider.value / 100; 
    }
});

seekSlider.addEventListener('input', () => {
    if (currentAudio) {
        currentAudio.currentTime = (seekSlider.value / 100) * currentAudio.duration; 
    }
});

const playPauseBtn = document.getElementById('play-pause-btn');
playPauseBtn.addEventListener('click', () => {
    if (isPlaying) {
        currentAudio.pause();
        updatePlayPauseButton(false); 
    } else {
        currentAudio.play();
        updatePlayPauseButton(true);
    }
    isPlaying = !isPlaying;
});

function updatePlayPauseButton(isPlaying) {
    const playPauseIcon = document.getElementById('play-pause-btn').querySelector('i');
    if (isPlaying) {
        playPauseIcon.classList.remove('fa-play');
        playPauseIcon.classList.add('fa-pause');
    } else {
        playPauseIcon.classList.remove('fa-pause');
        playPauseIcon.classList.add('fa-play');
    }
}

const prevBtn = document.getElementById('prev-btn');
const nextBtn = document.getElementById('next-btn');
const tracks = Array.from(document.querySelectorAll('.spotify-playlist .card .item'));

let currentTrackIndex = 0;

prevBtn.addEventListener('click', () => {
    currentTrackIndex = (currentTrackIndex - 1 + tracks.length) % tracks.length;
    const selectedTrack = tracks[currentTrackIndex];
    const audioSrc = selectedTrack.getAttribute('data-audio');
    playAudio(audioSrc);
    document.getElementById('track-title').textContent = selectedTrack.querySelector('h4').textContent;
});

nextBtn.addEventListener('click', () => {
    currentTrackIndex = (currentTrackIndex + 1) % tracks.length;
    const selectedTrack = tracks[currentTrackIndex];
    const audioSrc = selectedTrack.getAttribute('data-audio');
    playAudio(audioSrc);
    document.getElementById('track-title').textContent = selectedTrack.querySelector('h4').textContent;
});

if (currentAudio) {
    currentAudio.addEventListener('ended', () => {
        nextBtn.click(); 
    });
}
