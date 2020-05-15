import {
  INIT_STATE,
  UPDATE_FIELD,
  SAVE_ERROR,
  SAVE_SUCCESS,
  SAVING

} from "../constants/";

export function initState(payload) {
  return { type: INIT_STATE, payload }
};

export function changeField(field) {
  return { type: UPDATE_FIELD, payload: field }
}


export function submitForm(data) {
    console.log('DATA',data);

    return updateContent(data);
}

export function saving(boolean) {
  return { type: SAVING, payload:boolean };
}

export function updateContent(data) {

    return (dispatch) => {

      dispatch(saving(true));

      axios.post('/architect/styles/' + data.id + '/update', data)
          .then((response) => {
              console.log('THEN',response.data);
              if(response.data.success) {
                  dispatch(onSaveSuccess(response.data));
              }
          })
          .catch((error) => {
            console.log('CATCH',error);

              dispatch(saving(false));

              if (error.response) {
                  dispatch(onSaveError(error.response.data));
              } else if (error.message) {
                  toastr.error(error.message);
              } else {
                  //console.log('Error', error.message);
              }
          });

    }
}


export function onSaveError(response) {

  var errors = response.errors ? response.errors : null;
  var stateErrors = {};

  if(errors) {

      var fields = errors.fields ? errors.fields : null;

      if(fields) {
          fields.map(function(field){
             Object.keys(field).map(function(identifier){
                 stateErrors[identifier] = field[identifier];
             })
          });
      }
  }

  if(response.message) {
      toastr.error(response.message);
  }

  return {type : SAVE_ERROR, payload : stateErrors};

}

export function onSaveSuccess(response) {
    if(response.success) {

        toastr.success(Lang.get('models.content_saved'));

        return {type : SAVE_SUCCESS};
    }
}
