document.addEventListener("DOMContentLoaded", function () {
    const intro = document.getElementById("intro");

    // Duration of intro before redirection
    setTimeout(() => {
        intro.classList.add("hidden"); // Trigger fade-out animation

        setTimeout(() => {
            window.location.href = "index.html"; // Redirect to homepage
        }, 1000); // Match fade-out duration
    }, 3000); // Intro duration before fade-out starts
});
