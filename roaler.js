//import { username } from "./login";

//import { username } from "./login";

const username = 'Renovant'
const sendbutton = document.querySelector('.sendbutton');
const chat = document.querySelector('.chat');

const usernameTag = document.querySelector('.profile-name');
usernameTag.innerHTML = username;

const deleteMessage = document.querySelectorAll('.deleteMessage')

function runMessageRoll() {
    let messageListHTML = '';
    for (let index = messageArray.length-1; index >=0 ; index--) {
        const element = messageArray[index];
        const html = `<div class="tweet-content"><strong>${username}</strong><p>${element}</p><button class = "deleteMessage" 
        onclick = "messageArray.splice(${index},1); runMessageRoll()">
        delete</button></div>`;
        messageListHTML += html;
    }
    document.querySelector('.Roll').innerHTML = messageListHTML;
}

const messageArray = [];

sendbutton.addEventListener('click', () => {
    var messageSent = chat.value;

    if (messageSent === null || messageSent === "") {
        // Do nothing or handle the case where messageSent is null or empty
    } else {
        messageArray.push(messageSent);
        chat.value = null;
        runMessageRoll();
    }
});




// Call runMessageRoll on page load to display existing messages
runMessageRoll();
