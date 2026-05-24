document.addEventListener("DOMContentLoaded", function () {
  const urlParams = new URLSearchParams(window.location.search);
  const msg = urlParams.get("msg");

  if (msg) {
    const toast = document.createElement("div");
    toast.className = `toast ${msg === "success" ? "" : "error"}`;
    toast.textContent =
      msg === "success"
        ? "Message sent successfully!"
        : "Failed to send message. Please try again.";

    document.getElementById("toast-container").appendChild(toast);

    // Show the toast
    setTimeout(() => {
      toast.style.display = "block";
    }, 100); // Small delay to ensure element is rendered

    // Hide after 4 seconds
    setTimeout(() => {
      toast.style.opacity = "0";
      toast.style.transform = "translateY(-10px)";
    }, 4000);

    // Remove from DOM after transition
    setTimeout(() => {
      toast.remove();
    }, 4600);

    // Clean up URL
    window.history.replaceState({}, document.title, window.location.pathname);
  }
});
