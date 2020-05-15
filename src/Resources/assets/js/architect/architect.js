//------------------------------------------//
//      BOOTSTRAP FOR ARCHITECT LIB
//      @syntey-digital - 2018
//------------------------------------------//

var architect = {

    _debugEnabled : true,

    currentUserHasRole: function(roleName) {
        var user = CURRENT_USER;

        if(!user) {
            return false;
        }

        return roleName == user.role;
    },

    log : function(...params) {
        console.log("log!");
        if(this._debugEnabled){
            console.log('[Architect] :: ', ...params);
        }
    },

    error : function(...params) {
        console.error('[Architect] :: ', ...params);
    }

};
