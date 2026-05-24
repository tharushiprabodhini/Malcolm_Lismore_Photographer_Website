document.addEventListener("DOMContentLoaded", () => {
  const params = new URLSearchParams(window.location.search);
  const msg = params.get("msg");

  if (msg) {
    const toast = document.createElement("div");
    toast.className = "toast";

    switch (msg) {
      case "registered":
        toast.textContent = "Account created successfully!";
        break;
      case "exists":
        toast.textContent = "This email is already registered.";
        toast.classList.add("error");
        break;
      case "passwordmismatch":
        toast.textContent = "Passwords do not match.";
        toast.classList.add("error");
        break;
      case "invalidemail":
        toast.textContent = "Invalid email address.";
        toast.classList.add("error");
        break;
      case "empty":
        toast.textContent = "All fields are required.";
        toast.classList.add("error");
        break;
      case "error":
      default:
        toast.textContent = "An error occurred. Please try again.";
        toast.classList.add("error");
    }

    toast.style.display = "block";
    document.getElementById("toast-container").appendChild(toast);
    window.history.replaceState({}, document.title, window.location.pathname);
  }
});
