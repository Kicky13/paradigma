var app = {
    // Application Constructor
    initialize: function() {
        this.bindEvents();
    },
    // Bind Event Listeners
    //
    // Bind any events that are required on startup. Common events are:
    // 'load', 'deviceready', 'offline', and 'online'.
    bindEvents: function() {
        document.addEventListener('deviceready', this.onDeviceReady, false);
        
//         // Enable to debug issues.
//          window.plugins.OneSignal.setLogLevel({logLevel: 0, visualLevel: 0});
        
//           //the callBack function called when we click on the notification received
//           var notificationOpenedCallback = function(jsonData)
//           {
//             alert("terima gaji...!");
//           };
        
// //        var notificationOpenedCallback = function(jsonData) {
// //        console.log('notificationOpenedCallback: ' + JSON.stringify(jsonData));
// //        };
        
//         window.plugins.OneSignal
//         .startInit("bdbf3776-a783-4177-b4da-e153f90190ad", "451667976017")
//         .handleNotificationOpened(notificationOpenedCallback)
//         .endInit();
        // Sync hashed email if you have a login system or collect it.
        //   Will be used to reach the user at the most optimal time of day.
        // window.plugins.OneSignal.syncHashedEmail(userEmail);
    },
    onDeviceReady: function() {
        app.receivedEvent('deviceready');
        document.getElementById("getOrientation").addEventListener("click", getOrientation);
        document.getElementById("watchOrientation").addEventListener("click", watchOrientation);
    },
    // Update DOM on a Received Event
    receivedEvent: function(id) {
        var parentElement = document.getElementById(id);
        var listeningElement = parentElement.querySelector('.listening');
        var receivedElement = parentElement.querySelector('.received');

        listeningElement.setAttribute('style', 'display:none;');
        receivedElement.setAttribute('style', 'display:block;');
    }
};


function getOrientation(){
   navigator.compass.getCurrentHeading(compassSuccess, compassError);

   function compassSuccess(heading) {
      alert('Heading: ' + heading.magneticHeading);
   };

   function compassError(error) {
      alert('CompassError: ' + error.code);
   };
	
}

function watchOrientation(){
    
   var compassOptions = {
      frequency: 3000
   }

   var watchID = navigator.compass.watchHeading(compassSuccess, compassError, compassOptions);

   function compassSuccess(heading) {
      alert('Heading: ' + heading.magneticHeading);

      setTimeout(function() {
         navigator.compass.clearWatch(watchID);
      }, 10000);

   };

   function compassError(error) {
      alert('CompassError: ' + error.code);
   };
	
}

app.initialize();