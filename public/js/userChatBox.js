const id = document.getElementById('sender_hidden').value;
const recipientId = document.getElementById('recipient_hidden').value;
const chatBox = document.getElementById('messages_list');
const postButtonElement = document.getElementById('button-addon2');
const postInputElement = document.getElementById('post_input_element');

window.addEventListener('load', function () {
    getConversation(id);
});

postButtonElement.addEventListener('click', function (e) {
    // on stop le submit
    e.preventDefault();

    // on récupère les données du message (destinataire et message)
    const message = postInputElement.value;

    // on formate les données envoyée au serveur
    const data = new FormData();
    data.append('sender', id);
    data.append('recipient', recipientId);
    data.append('content', message);

    sendData(data, id);
})

const interval = window.setInterval(
    getConversation, 3000, id
)

function clearPreviousChat() {
    child = chatBox.lastElementChild;
    while (child) {
        chatBox.removeChild(child);
        child = chatBox.lastElementChild;
    }
}

function getConversation(id) {
    let request = new XMLHttpRequest();
    request.open('GET', 'https://localhost:8000/conversation/' + id);
    request.responseType = 'json';
    request.onload = function (e) {
        datas = request.response;
        displayConversation(datas)
    }
    request.send();
}

function displayConversation(datas) {

    clearPreviousChat();

    for (const message of datas) {
        //on crée l'élément message
        let messageElement = document.createElement('ul');
        messageElement.id = 'message';
        messageElement.classList.add('list-group');
        messageElement.classList.add('w-75');

        // on crée le span de l'élément message
        let badgeElement = document.createElement('span');
        badgeElement.classList.add('badge');
        badgeElement.classList.add('bg-primary');
        badgeElement.classList.add('w-50');

        // on crée le li de l'élément message
        let msg = document.createElement('li');
        msg.classList.add('list-group-item');
        msg.classList.add('list-group-item-info');

        // pour cahque message de la conversation, on hydrate les données dans les éléments et on les insère dans la chatbox
        badgeElement.innerHTML = message.sender
        msg.innerHTML = message.content;

        messageElement.append(badgeElement);
        messageElement.append(msg);
        chatBox.appendChild(messageElement);
    }
    chatBox.scrollTop = chatBox.scrollHeight;
}

function sendData(data, recipientId) {
    let ajaxRequest = new XMLHttpRequest();
    ajaxRequest.open('POST', 'https://localhost:8000/addMessage');
    ajaxRequest.onload = function (e) {
        postInputElement.value = '';
        postInputElement.focus();
        // on récupère tous les messages pour réaffichage avec le dernier posté
        getConversation(id);
    }
    ajaxRequest.send(data);
}
