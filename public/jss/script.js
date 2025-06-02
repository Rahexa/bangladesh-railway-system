var bangladeshiStations = [
    'Dhaka Junction',
    'Chittagong Central',
    'Khulna Terminal',
    'Rajshahi Station',
    'Sylhet Junction',
    'Barisal Central',
    'Rangpur Terminal',
    'Comilla Junction',
    'Mymensingh Central',
    'Jessore Station'
];

function populateDropdowns() {
    var fromDropdown = document.getElementById('from');
    var toDropdown = document.getElementById('to');

    bangladeshiStations.forEach(function (station) {
        var option = document.createElement('option');
        option.value = station;
        option.textContent = station;

        fromDropdown.appendChild(option.cloneNode(true));
        toDropdown.appendChild(option);
    });
}

populateDropdowns();

function toggleAccountInfo() {
    var accountInfo = document.getElementById('accountInfo');
    if (accountInfo.style.display === 'none') {
        accountInfo.style.display = 'block';
    } else {
        accountInfo.style.display = 'none';
    }
}

function showBookingForm() {
    document.getElementById("bookingForm").style.display = "block";
}

function updateClock() {
    var now = new Date();
    var hours = now.getHours();
    var minutes = now.getMinutes();
    var seconds = now.getSeconds();

    hours = (hours < 10 ? "0" : "") + hours;
    minutes = (minutes < 10 ? "0" : "") + minutes;
    seconds = (seconds < 10 ? "0" : "") + seconds;

    var timeString = hours % 12 + ":" + minutes + ":" + seconds + " " + (hours < 12 ? "AM" : "PM");

    document.getElementById("clock").innerHTML = timeString;
    setTimeout(updateClock, 1000);
}

updateClock();

function toggleLogoutButton() {
    var logoutButton = document.getElementById('logoutButton');
    logoutButton.style.display = (logoutButton.style.display === 'block') ? 'none' : 'block';
}

function toggleMenu() {
    var menuContent = document.querySelector('.menu-content');
    menuContent.classList.toggle('show');
}

function logout() {
    alert('Logged out successfully!');
}

function showTransactionIDBox() {
    var paymentMethods = document.getElementsByName("paymentMethod");
    var transactionIDBox = document.getElementById("transactionIDBox");

    for (var i = 0; i < paymentMethods.length; i++) {
        if (paymentMethods[i].checked) {
            transactionIDBox.style.display = "block";
            return;
        }
    }
    transactionIDBox.style.display = "none";
}

var paymentMethodRadios = document.querySelectorAll('input[name="paymentMethod"]');
paymentMethodRadios.forEach(function(radio) {
    radio.addEventListener('click', showTransactionIDBox);
});

// Add event listener to the form submit
document.querySelector("form").addEventListener("submit", showTotalPayment);

// Handle form submission to show total payment
function showTotalPayment(event) {
    event.preventDefault(); // Prevent form submission
    const totalAmount = calculateTotalPayment();
    document.getElementById("totalAmount").textContent = totalAmount;
    document.getElementById("totalPaymentPopup").style.display = "flex";
}

function showPaymentMethods() {
    document.getElementById("totalPaymentPopup").style.display = "none";
    document.getElementById("paymentMethodPopup").style.display = "flex";
}

function processPayment(method) {
    document.getElementById("paymentMethodPopup").style.display = "none";
    document.getElementById("paymentSuccessPopup").style.display = "flex";
}

function closePopup(popupId) {
    document.getElementById(popupId).style.display = "none";
}

function calculateTotalPayment() {
    const classValue = document.getElementById("class").value;
    const ticketType = document.getElementById("ticketType").value;

    let totalAmount = 0;

    if (classValue === "economy") totalAmount += 500;
    if (classValue === "business") totalAmount += 1000;
    if (classValue === "firstClass") totalAmount += 1500;

    if (ticketType === "adult") totalAmount += 200;
    if (ticketType === "children") totalAmount += 100;

    return totalAmount;
}
