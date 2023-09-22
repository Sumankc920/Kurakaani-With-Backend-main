let hamburgerContainer = document.querySelector(".hamburger");
let hamburgerIcon = document.querySelector(".hamburger-icon");
let sideBar = document.querySelector(".online-preview-container");
let backdrop = document.querySelector(".backdrop");
let senderMessageContainer = document.querySelectorAll(".sender-message-container");
let userMessageContainer = document.querySelector(".user-messages-container");
let messageSection = document.querySelector(".message-section");
let userTitleContainer = document.querySelector(".user-title-container");
let enterMessageContainer = document.querySelector(".enter-message-container");
let messageInputContainer = document.querySelector(".message-text");
let messageSendButton = document.querySelector(".send-button");
let sideActiveUsers = document.querySelector(".online-preview-container__online-users-container");
let messageForm = document.querySelector(".message-form");
let messageText = document.querySelector(".message-text");
let searchUsers = document.querySelector(".user-search");


let collections = {
    enteredMessages : [],
}


let senderMessage;
senderMessageContainer = Array.from(senderMessageContainer);

hamburgerIcon.addEventListener("click" , () => {
    backdrop.classList.add("backdrop-active");
    sideBar.classList.add("online-preview-container-active");
})

backdrop.addEventListener("click" , () => {
    backdrop.classList.remove("backdrop-active");
    sideBar.classList.remove("online-preview-container-active");
})

// for first load
//senderMessageContainer.forEach(el => {
//    el.style.left = `${(userMessageContainer.clientWidth - 20) - el.clientWidth}px`;
//})


// After each resizing
window.addEventListener("resize" , () => {
    // To arrange sender message at the right
    senderMessageContainer.forEach(el => {
    el.style.left = `${(userMessageContainer.clientWidth - 20) - el.clientWidth}px`;
    })

    // To manage the height of userMessageContainer
    userMessageContainer.style.height = `${messageSection.clientHeight - userTitleContainer.clientHeight - enterMessageContainer.clientHeight}px`;
})

// When we click the user message title
//const userInfoClick = () => {
//    let userinfo = Array.from(userInfo);
//    userinfo.forEach((el , ind) => {
//        el.addEventListener("click" , () => {
//            for(let i=0 ; i<userInfo.length ; i++)
//                {
//                    if(ind!==i)
//                        {
//                            userinfo[i].style.backgroundColor = "#dddddd";
//                        }
//                }
//            el.style.backgroundColor = "#fff";
//        })
//    })   
//}

const clickableUsers = ["user-info" , "user-info-heading" , "user-info-message"];
function userInfoClick() {
    sideActiveUsers.addEventListener("click" , (e) => {
        let el = e.target;
        // We're only interested in user-info clicks:
        if(!(clickableUsers.includes(el.classList[0]))){
            return ;
        }
        // Since we clicked on a user-info, the following will now have matches:
        for (const sibling of sideActiveUsers.querySelectorAll(".user-info")) {
            sibling.style.backgroundColor = "#dddddd";
        }
        if(el.classList[0] == "user-info-heading" || el.classList[0] == "user-info-message") {
            el = el.parentNode.parentNode.parentNode;
        }
        
        el.style.backgroundColor = "#fff";
        getMessageFromUsers(el.id);
        getDetails(el.id);
//        getMessage(el);
        
        
    });
    userMessageContainer.scrollTop = userMessageContainer.clientHeight;

}

const getMessageFromUsers = (id) => {
    let xhttp = new XMLHttpRequest();
    xhttp.open("POST" , "./getMessageFromUsers.php" , true);
    xhttp.onload = () => {
        if(xhttp.readyState === XMLHttpRequest.DONE) {
            if(xhttp.status === 200) {
                let data = xhttp.response;
                userMessageContainer.innerHTML = data;
                for(let el of userMessageContainer.childNodes) {
                    if(el.classList[0] === "sender-message-container") {
                        let element = document.querySelectorAll(".sender-message-container");
                        element.forEach(el => {
                            el.style.left = `${(userMessageContainer.clientWidth - 20) - el.clientWidth}px`;
                        })
                        
                        window.addEventListener("resize" , () => {
                            // To arrange sender message at the right
                            element.forEach(el => {
                                el.style.left = `${(userMessageContainer.clientWidth - 20) - el.clientWidth}px`;
                            })
                        })
                    }
                }
            }
        }
    }
    xhttp.setRequestHeader("Content-type" , "application/x-www-form-urlencoded");
    xhttp.send("id=" + id);
}

// to get the name of the user on the top when clicked;
const getDetails = (id) => {
    if(userTitleContainer.children.length > 2){
        userTitleContainer.removeChild(document.querySelector(".user-image-and-name-container"));
        userTitleContainer.removeChild(document.querySelector(".icons-container"));   
    }
    let xhttp = new XMLHttpRequest();
    xhttp.open("POST" , "./getDetails.php" , "true");
    xhttp.onload = () => {
        if(xhttp.readyState === XMLHttpRequest.DONE) {
            if(xhttp.status === 200) {
                let data = xhttp.response;
                hamburgerContainer.insertAdjacentHTML("afterend" , data);
//                console.log(data);
            }
        }
    }
    xhttp.setRequestHeader("Content-type" , "application/x-www-form-urlencoded");
    xhttp.send("id=" + id);
}


// To select first friend's message immediately after the page loads
window.addEventListener("load" , () => {
    messageText.value = "";
    //setTimeout(() =>
        let xhttp = new XMLHttpRequest();
        xhttp.open("GET", "./messagedUsers.php", true);
        xhttp.onload = () => {
            if(xhttp.readyState === XMLHttpRequest.DONE) {
                if(xhttp.status === 200) {
                    let data = xhttp.response;
                    sideActiveUsers.innerHTML = data;
                    sideActiveUsers.childNodes[0].style.backgroundColor = "#fff";
                    getMessageFromUsers(sideActiveUsers.childNodes[0].id);
                    getDetails(sideActiveUsers.childNodes[0].id);
                }
            }
        }
        xhttp.send();
        userInfoClick();
    //} , 500);
    messageInputContainer.focus();
        

    
})


//When user writes on message container
messageInputContainer.addEventListener("keyup" , (e) => {
    senderMessage = e.target.value;
})

messageForm.addEventListener("submit" , (e) => {
    console.log(messageText.value);
    if(messageText.value == "") {
        e.preventDefault();
    }
})

// when we search users in the search bar
searchUsers.addEventListener("keyup" , (e) => {
    let user = e.target.value;
    // sending ajax request
    let xhttp = new XMLHttpRequest();
    xhttp.open("POST" , "searchUsers.php" , true);
    xhttp.onload = () => {
        if(xhttp.readyState === XMLHttpRequest.DONE){
            if(xhttp.status === 200){
                let data = xhttp.response;
                
                console.log(data);
            }
        }
    }
    xhttp.setRequestHeader("Content-type" , "application/x-www-form-urlencoded");
    xhttp.send("user=" + user);
})




//setInterval(() => {
//    let xhttp = new XMLHttpRequest();
//    xhttp.open("GET", "#", true);
//    xhttp.onload = () => {
//        if(xhttp.readyState === XMLHttpRequest.DONE) {
//            if(xhttp.status === 200) {
//                let data = xhttp.response;
//                console.log(data);
//            }
//        }
//    }
//    xhttp.send();
//} , 500);


















