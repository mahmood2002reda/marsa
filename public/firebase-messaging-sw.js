importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
   
firebase.initializeApp({
    apiKey: "AIzaSyCJBqvTSYUi7UVAnvvA-wvNBPI0ouSaN7A",
    projectId: "maras-73dd1",
    messagingSenderId: "433488271849",
    appId: "1:433488271849:web:1841b9ae4c44c5b7771378",});
  
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function({data:{title,body,icon}}) {
    return self.registration.showNotification(title,{body,icon});
});