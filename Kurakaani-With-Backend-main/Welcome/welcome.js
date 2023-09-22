let infoContainer = document.querySelector(".info-container");
let okButton = document.querySelector(".ok-button");
let body = document.querySelector("body");
let targetUserSpan = document.querySelector(".to");
let popupMessageContainer = document.querySelector(".popup-message-container");
let crossIcon = document.querySelector(".cross");
let layer = document.querySelector(".layer");
let receiverName = document.querySelector(".receiver-name");
let messageForm = document.querySelector(".message-form");
let logoutLink = document.querySelector(".logout-link");
let logoutInfoContainer = document.querySelector(".logout-info-container");
let logoutOkButton = document.querySelector(".logout-ok-button");

// When window loads for the first time
window.addEventListener("load" , () => {
    if(sessionStorage.getItem("popup") !== "true") {
        infoContainer.style.transform = "translateY(0vh)";
        body.style.backgroundColor = "#ddd";
    }
    sessionStorage.setItem("popup" , "true");

})

// When ok button is clicked
okButton.addEventListener("click" , () => {
    infoContainer.style.transform = "translateY(-100vh)";
    body.style.backgroundColor = "#fff";
})

// showing the popup when user hits the message icon.
const generatePopUp = (e) => {
    let targetUser = e.target.parentNode.parentNode.childNodes[1].childNodes[3].textContent;
    targetUserSpan.textContent = targetUser;
    popupMessageContainer.style.bottom = "0%";
    receiverName.value = targetUser;
}

// Blocking current user's messaging if the current user is 
// the admin.

let username = document.querySelector(".heading-container").childNodes[1].textContent;

let adminsName = document.querySelectorAll(".admin-info span");
adminsName = Array.from(adminsName);
for(let i=0 ; i<adminsName.length ; i++) {
    if(username.search(adminsName[i].textContent) >= 0) {
        let icons = adminsName[i].parentNode.nextElementSibling.childNodes;
        icons[1].style.filter = "brightness(0.5)";
        icons[3].style.filter = "brightness(0.5)";
        icons[5].style.filter = "brightness(0.5)";
    }else {
        let messageIcon = adminsName[i].parentNode.nextElementSibling.childNodes[1];
        messageIcon.addEventListener("click" , generatePopUp);
    }
}

// when we try to send quick message to the users
const generatePopUpFriend = (e) => {
    let targetUser = e.target.parentNode.parentNode.childNodes[0].childNodes[1].textContent;
    console.log(targetUser);
    targetUserSpan.textContent = targetUser;
    popupMessageContainer.style.bottom = "0%";
    receiverName.value = targetUser;
}

let usersName = document.querySelectorAll(".users span");
usersName = Array.from(usersName);
for(let i=0 ; i<usersName.length ; i++) {
    let messageIcon = usersName[i].parentNode.nextElementSibling.childNodes[0];
    messageIcon.addEventListener("click" , generatePopUpFriend);
}

logoutLink.addEventListener("click" , () => {
    logoutInfoContainer.style.transform = "translateY(0vh)";
    body.style.backgroundColor = "#ddd";
})

logoutOkButton.addEventListener("click" , () => {
    logoutInfoContainer.style.transform = "translateY(-100vh)";
    logoutLink.setAttribute("href" , "../log-out/logout.php")
    logoutLink.click();
})


// when we click cross icon 
crossIcon.addEventListener("click" , () => {
    popupMessageContainer.style.bottom = "100%";
})












