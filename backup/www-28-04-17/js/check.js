var app = {
    initialize: function() {
        this.bindEvents();
    },
    bindEvents: function() {
        document.addEventListener('deviceready', this.onDeviceReady, false);
    },
    onDeviceReady: function() {
        addCheckAppUpdateInfo();
        checkAppUpdate();   
    }
};

function addCheckAppUpdateInfo() {
    $('check').addEventListener("click", checkAppUpdate);
    $('version').innerHTML = AppVersion.build;
    $('updateurl').value = "http://par4digma.semenindonesia.com/update/version.xml";
}

function checkAppUpdate() {
    var updateUrl = $('updateurl').value;
    window.AppUpdate.checkAppUpdate(onSuccess, onFail, updateUrl);

    var me = this;
    function onFail() {console.log('fail', JSON.stringify(arguments), arguments);}
    function onSuccess() {
        console.log('success', JSON.stringify(arguments), arguments);
        me.innerHTML+="<br/>request-completed";
        window.location.href = 'index_login2.html';
    }
}

function $(id) {
    return document.getElementById(id);
}

app.initialize();
