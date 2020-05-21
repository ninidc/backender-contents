var routes = require('./routes.json');

exports.route = function (name, args) {
    if (routes[name] === undefined) {
        console.error('Unknown route. Try to export the latest.', name);
        return null;
    } 

    return '/' + routes[name].replace(/({.*})/g, function(param) {
        return args[param.replace('{', '').replace('}', '')];
    });
};