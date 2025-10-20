const myPlaceBtn = document.getElementById("myPlaceBtn");
const ourHubBtn = document.getElementById("ourHubBtn");
const addressSection = document.getElementById("addressSection");
const selectIcon = document.querySelector(".ob-select-icon");
const proceedBtn = document.getElementById("continueBtn");

myPlaceBtn.addEventListener("click", () => {
  myPlaceBtn.classList.add("active");
  ourHubBtn.classList.remove("active");
  selectIcon.classList.remove("d-none");
  addressSection.classList.remove("d-none");
});

ourHubBtn.addEventListener("click", () => {
  ourHubBtn.classList.add("active");
  myPlaceBtn.classList.remove("active");
  selectIcon.classList.add("d-none");
  addressSection.classList.add("d-none");
});

proceedBtn.addEventListener("click", function() {
  const checkbox = document.getElementById("confirmCheck");
  if (!addressSection.classList.contains("d-none") && !checkbox.checked) {
    alert("Please confirm you can provide water and electricity before continuing.");
  } else {
        window.location = "./select-car.html";
  }
});


// Optional: You can add interactivity here later (like selecting a car)
document.querySelectorAll('.ob-car-card').forEach(card => {
  card.addEventListener('click', () => {
    alert(`You selected: ${card.querySelector('.ob-car-name').innerText}`);
  });
});


function goToPlan(){
            window.location = "./select-plan.html";

}
document.querySelectorAll('.ob-tab-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.ob-tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
  });
});

function goToDate(){
            window.location = "./select-date.html";

}
function goToBooking(){
            window.location = "./booking-details.html";

}
function goToPayNow(){
            window.location = "./pay-now.html";

}
function goToBookingPlace(){
            window.location = "./booking-placed.html";

}


function copyAccount() {
  const accountNumber = document.getElementById("accountNumber").innerText;
  navigator.clipboard.writeText(accountNumber);
  alert("Account number copied!");
}

function fileSelected() {
  const fileInput = document.getElementById("proof");
  const confirmBtn = document.getElementById("confirmBtn");
  const uploadBtn = document.getElementById("uploadBtn");

  if (fileInput.files.length > 0) {
    uploadBtn.innerText = "Uploaded ✓";
    confirmBtn.disabled = false;
  } else {
    uploadBtn.innerText = "Upload";
    confirmBtn.disabled = true;
  }
}
