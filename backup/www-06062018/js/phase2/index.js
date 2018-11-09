/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */
var app = {
    // Application Constructor
    initialize: function () {
        this.bindEvents();
    },
    // Bind Event Listeners
    //
    // Bind any events that are required on startup. Common events are:
    // 'load', 'deviceready', 'offline', and 'online'.
    bindEvents: function () {
        document.addEventListener('deviceready', this.onDeviceReady, false);
    },
    // deviceready Event Handler
    //
    // The scope of 'this' is the event. In order to call the 'receivedEvent'
    // function, we must explicitly call 'app.receivedEvent(...);'
    onDeviceReady: function () {
        
        /* Invoke sync with the custom options, which enables user interaction.
           For customizing the sync behavior, see SyncOptions in the CodePush documentation. */
        window.codePush.sync(
            function (syncStatus) {
                switch (syncStatus) {
                    // Result (final) statuses
                    case SyncStatus.UPDATE_INSTALLED:
                        // codePush.restartApplication();
                        $("#download_progress").html("Update completed");
                        // app.displayMessage("The update was installed successfully. For InstallMode.ON_NEXT_RESTART, the changes will be visible after application restart. ");
                        break;
                    case SyncStatus.UP_TO_DATE:
                        // $("#change-meta").attr("content", "default-src *; style-src *  'unsafe-inline'; script-src *  'unsafe-inline'; media-src *");
                        // app.displayMessage("The application is up to date.");
                        $("#download_progress").html("App is up to date");
                        break;
                    case SyncStatus.UPDATE_IGNORED:
                        $("#download_progress").html("The user decided not to install the optional update");
                        // app.displayMessage("The user decided not to install the optional update.");
                        break;
                    case SyncStatus.ERROR:
                        $("#download_progress").html("An error occured while checking for updates");
                        // app.displayMessage("An error occured while checking for updates");
                        break;
                    
                    // Intermediate (non final) statuses
                    case SyncStatus.CHECKING_FOR_UPDATE:
                        $("#download_progress").html("Checking for update");
                        break;
                    case SyncStatus.AWAITING_USER_ACTION:
                        // console.log("Alerting user.");
                        $("#download_progress").html("Alerting user");
                        break;
                    case SyncStatus.DOWNLOADING_PACKAGE:
                        // console.log("Downloading package.");
                        $("#download_progress").html("Downloading package");
                        break;
                    case SyncStatus.INSTALLING_UPDATE:
                        $("#download_progress").html("Installing update");
                        break;
                }
            },
            {
                installMode: InstallMode.IMMEDIATE, updateDialog: false
            },
            function (downloadProgress) {
                $("#download_progress").html("Downloading " + downloadProgress.receivedBytes + " of " + downloadProgress.totalBytes + " bytes.");
            });
            
        // continue application initialization
        app.receivedEvent('deviceready');
        // codePush.sync({installMode: InstallMode.IMMEDIATE});
    },
    // Update DOM on a Received Event
    receivedEvent: function (id) {
        var parentElement = document.getElementById(id);
        var listeningElement = parentElement.querySelector('.listening');
        var receivedElement = parentElement.querySelector('.received');

        listeningElement.setAttribute('style', 'display:none;');
        receivedElement.setAttribute('style', 'display:block;');

        console.log('Received Event: ' + id);
    },
    // Displays an alert dialog containing a message.
    displayMessage: function (message) {
        navigator.notification.alert(
            message,
            null,
            'PAR4DIGMA',
            'OK');
    }
};

app.initialize();