// Horizontal Slider Timeline with Auto-play and Drag
document.addEventListener('DOMContentLoaded', function() {
    // Check if timeline elements exist
    if (typeof timelineData === 'undefined' || !timelineData || timelineData.length === 0) {
        return;
    }

    const slider = document.getElementById("timelineSlider");
    const eventYear = document.getElementById("eventYear");
    const eventCompany = document.getElementById("eventCompany");
    const eventDescription = document.getElementById("eventDescription");
    const progressFill = document.getElementById("progressFill");
    const timelineContainer = document.getElementById("timelineContainer");
    const content = document.getElementById("timelineContent");
    const sliderTrack = document.getElementById("sliderTrack");
    const yearLabelsContainer = document.getElementById("yearLabels");

    if (!slider || !eventYear || !eventCompany || !eventDescription) {
        return;
    }

    let currentIndex = 0;
    let ticks = [];
    let yearLabels = [];
    let autoPlayInterval;

    // Create tick marks along slider track
    function createTicks() {
        timelineData.forEach((event, index) => {
            const tick = document.createElement("div");
            tick.classList.add("tick");
            const percent = (index / (timelineData.length - 1)) * 100;
            tick.style.left = `calc(${percent}%)`;
            sliderTrack.appendChild(tick);
            ticks.push(tick);
        });
    }

    // Create year labels under slider with precise positioning
    function createYearLabels() {
        yearLabelsContainer.style.position = "relative";

        timelineData.forEach((event, index) => {
            const span = document.createElement("span");
            span.classList.add("year-label");
            span.textContent = event.year;

            const percent = (index / (timelineData.length - 1)) * 100;
            span.style.position = "absolute";
            span.style.left = `${percent}%`;
            span.style.transform = "translateX(-50%)";

            yearLabelsContainer.appendChild(span);
            yearLabels.push(span);
        });
    }

    function updateTimeline(index) {
        if (index === currentIndex) return;

        // Add fade out animation to current content
        content.classList.remove("fade-in");
        content.classList.add("fade-transition");

        eventYear.classList.add("fade-out");
        eventCompany.classList.add("fade-out");
        eventDescription.classList.add("fade-out");

        ticks.forEach((tick, i) => {
            tick.classList.toggle("active", i === index);
        });

        yearLabels.forEach((label, i) => {
            label.classList.toggle("active", i === index);
        });

        // Wait for fade-out animation to finish before updating content
        setTimeout(() => {
            const event = timelineData[index];

            // Update content
            eventYear.textContent = event.year;
            eventCompany.textContent = event.company;
            eventDescription.textContent = event.description;

            const progress = (index / (timelineData.length - 1)) * 100;
            progressFill.style.width = `${progress}%`;

            // Reset and animate in
            content.classList.remove("fade-transition");
            eventYear.classList.remove("fade-out");
            eventCompany.classList.remove("fade-out");
            eventDescription.classList.remove("fade-out");

            content.classList.add("fade-in");

            currentIndex = index;
        }, 350); // Match the fade-out animation duration
    }

    // Slider manual interaction (drag/input)
    slider.addEventListener("input", function () {
        const index = parseInt(this.value);
        updateTimeline(index);
        stopAutoPlay(); // Stop auto-play when user interacts
    });

    // Auto-play functionality
    function startAutoPlay() {
        autoPlayInterval = setInterval(() => {
            let nextIndex = currentIndex + 1;
            if (nextIndex >= timelineData.length) {
                nextIndex = 0; // Loop back to the beginning
            }
            slider.value = nextIndex;
            updateTimeline(nextIndex);
        }, 2000); // Change slide every 2 seconds
    }

    function stopAutoPlay() {
        clearInterval(autoPlayInterval);
    }

    // Restart auto-play after user stops interacting
    let userInteractionTimeout;

    slider.addEventListener("mousedown", stopAutoPlay);
    slider.addEventListener("touchstart", stopAutoPlay);

    slider.addEventListener("mouseup", () => {
        clearTimeout(userInteractionTimeout);
        userInteractionTimeout = setTimeout(startAutoPlay, 5000); // Restart after 5 seconds of inactivity
    });

    slider.addEventListener("touchend", () => {
        clearTimeout(userInteractionTimeout);
        userInteractionTimeout = setTimeout(startAutoPlay, 5000);
    });

    // Initialize
    createTicks();
    createYearLabels();
    updateTimeline(0);

    // Start auto-play after initial load
    setTimeout(startAutoPlay, 2000);
});
