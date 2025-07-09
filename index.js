


document.addEventListener("DOMContentLoaded", function () {

  const searchBtn = document.getElementById("searchBtn");
    const cartBtn = document.getElementById("cartBtn");
    const profileBtn = document.getElementById("profileBtn");
    const profileMenu = document.getElementById("profileMenu");
  
    // Handle search click
    searchBtn.addEventListener("click", function () {
      alert("Redirecting to Search Page...");
      window.location.href = "search.html";
    });
  
    // Handle cart click
    cartBtn.addEventListener("click", function () {
      alert("Redirecting to Cart Page...");
      window.location.href = "cart.php";
    });
  
    // Toggle profile dropdown
    profileBtn.addEventListener("click", function () {
      profileMenu.style.display =
        profileMenu.style.display === "block" ? "none" : "block";
    });
  
    // Hide menu when clicking outside
    window.addEventListener("click", function (e) {
      if (!e.target.matches("#profileBtn") && !profileMenu.contains(e.target)) {
        profileMenu.style.display = "none";
      }
    });
  });




