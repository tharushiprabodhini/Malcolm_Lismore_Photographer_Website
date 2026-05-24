document.addEventListener("DOMContentLoaded", function () {
  const toast = document.getElementById("toast");

  const params = new URLSearchParams(window.location.search);
  if (params.get("success") === "1") {
    showToast("Booking submitted successfully!");
  } else if (params.get("error") === "1") {
    showToast("Failed to submit booking. Please try again.", true);
  }

  function showToast(message, isError = false) {
    toast.textContent = message;
    toast.classList.add("show");
    toast.style.display = "block";
    toast.classList.toggle("error", isError);

    setTimeout(() => {
      toast.style.display = "none";
      toast.classList.remove("error");
    }, 4000);
  }
});
