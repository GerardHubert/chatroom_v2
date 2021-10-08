// Définition des éléments du DOM à surveiller
const startButton = document.getElementById("start_button");
const userChoice = document.getElementById('user_choice');
const chatBox = document.getElementById('messages_list');
const sender = document.getElementById('sender_hidden');
const postButtonElement = document.getElementById('button-addon2');
const postInputElement = document.getElementById('post_input_element');

function clearPreviousChat() {
    child = chatBox.lastElementChild;
    while (child) {
        chatBox.removeChild(child);
        child = chatBox.lastElementChild;
    }
}

function displayConversation(datas) {

    clearPreviousChat();

    if (datas !== 'null') {
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
            badgeElement.classList.add('w-50')

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
}

startButton.addEventListener('click', function (e) {
    e.preventDefault();

    // on récupère l'id du user avec qui discuter
    userId = userChoice.value

    // on envoie une requête ajax pour avoir la conversation avec cet utilisateur
    getConversation(userId);
    const interval = window.setInterval(
        getConversation, 3000, userId
    )
})

postButtonElement.addEventListener('click', function (e) {
    // on stop le submit
    e.preventDefault();

    // on récupère les données du message (destinataire et message)
    const senderId = sender.value;
    const recipientId = userChoice.value;
    const message = postInputElement.value;

    // on formate les données envoyée au serveur
    const data = new FormData();
    data.append('sender', senderId);
    data.append('recipient', recipientId);
    data.append('content', message);

    sendData(data, recipientId);

})

function getConversation(id) {
    let ajaxRequest = new XMLHttpRequest();
    ajaxRequest.open('GET', 'https://localhost:8000/conversation/' + id);
    ajaxRequest.responseType = 'json';
    ajaxRequest.onload = function (e) {
        datas = ajaxRequest.response;
        displayConversation(datas)
    }
    ajaxRequest.send();
}

function sendData(data, recipientId) {
    let ajaxRequest = new XMLHttpRequest();
    ajaxRequest.open('POST', 'https://localhost:8000/addMessage');
    ajaxRequest.onload = function (e) {
        postInputElement.value = '';
        postInputElement.focus();
        // on récupère tous les messages pour réaffichage avec le dernier posté
        getConversation(recipientId);
    }
    ajaxRequest.send(data);
}

