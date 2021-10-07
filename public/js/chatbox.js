// Définition des éléments du DOM à surveiller
const startButton = document.getElementById("start_button");
const userChoice = document.getElementById('user_choice');
const chatBox = document.getElementById('messages_list');
const sender = document.getElementById('sender_hidden');
const postButtonElement = document.getElementById('button-addon2');
const postInputElement = document.getElementById('post_input_element');


startButton.addEventListener('click', function (e) {
    e.preventDefault();
    // on récupère l'id du user avec qui discuter
    console.log("on a choisit de discuté avec le user : " + userChoice.value)
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

    //test();
    console.log(data);
    sendData(data);

    // on raffraichit la zone de message avec le nouveau message (requête pour afficher)
})

function sendData(data) {
    let ajaxRequest = new XMLHttpRequest();
    ajaxRequest.open('POST', 'https://localhost:8000/addMessage');
    ajaxRequest.onload = function (e) {
        console.log('requête terminée');
    }
    ajaxRequest.send(data);
}

// function test() {
//     // on configure une requête ajax
//     let ajaxRequest = new XMLHttpRequest();
//     ajaxRequest.open('GET', "https://localhost:8000/addMessage");
//     ajaxRequest.responseType = 'json';
//     ajaxRequest.onload = function (e) {
//         console.log(ajaxRequest.response)
//     };

//     ajaxRequest.send();
// }

