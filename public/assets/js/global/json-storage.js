function saveGuiObject(type, name, config, callback) {
    $.post('/gui/json/save', {
        type: type,
        name: name,
        config: JSON.stringify(config)
    }, function(response) {
        if (callback) callback(JSON.parse(response));
    });
}

function fetchGuiObject(type, name, callback) {
    $.get('/gui/json/fetch', {
        type: type,
        name: name
    }, function(response) {
        if (callback) callback(JSON.parse(response));
    });
}
