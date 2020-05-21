import {
  INIT_STATE,
  UPDATE_FIELD,
  UPDATE_IMAGE

} from '../constants';

import update from 'immutability-helper';
import moment from 'moment';


var translations = {};
LANGUAGES.map(function(v,k){
    translations[v.iso] = true;
});

const initialState =  {
  form : null,
  layout : [],
  sidebar : [],
  body : [],
  fields : {},
  saved : false,
  saving : false
}

function appReducer(state = initialState, action) {

    const {fields} = state;

    console.log("action => ",action);
    switch(action.type) {
        case INIT_STATE:
        console.log("action INIT_STATE=> ",action.payload.fields);

            return {
                ...state,
                fields : action.payload.fields ? action.payload.fields : {},
                form : action.payload.form,
                layout : action.payload.layout,
                body : action.payload.layout.layout.body !== undefined ?
                  action.payload.layout.layout.body : null,
                sidebar : action.payload.layout.layout.sidebar !== undefined ?
                  action.payload.layout.layout.sidebar : null
            }

        case UPDATE_FIELD :

            // if not defined set new object
            if(!fields[action.payload.name]){
              fields[action.payload.name] = {
                value : action.payload.value,
                type : action.payload.type
              };
            }
            else {
              //just change value
              fields[action.payload.name].value = action.payload.value
            }

            return {
              ...state,
              fields : fields
            }
        case UPDATE_IMAGE :
            return {
              ...state,
              fields : action.payload
            }

        default:
            return state;
    }
}

export default appReducer;
