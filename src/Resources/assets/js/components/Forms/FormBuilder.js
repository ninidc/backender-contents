import React, {Component} from 'react'
import {connect} from 'react-redux';

import {initState,
  cancelImage, updateImage
} from './actions/';

import FormBar from './FormBar';
import FormSidebar from './FormSidebar';
import FormContent from './FormContent';
import MediaSelectModal from './../Medias/MediaSelectModal';

class FormBuilder extends Component {

    constructor(props) {
      super(props);

      var data = {
          //first state
          fields : props.fields ? JSON.parse(atob(props.fields)) : null,
          form : props.form ? JSON.parse(atob(props.form)) : null,
          layout : props.layout ? JSON.parse(atob(props.layout)) : []
      };
      //init state
      this.props.initState(data);

    }

    handleImageSelected(media){
       //console.log("Selected image => ",media,this.props.images);

        this.props.updateImage(
          this.props.images.sourceField,
          media,
          this.props.app.fields,
          this.props.images.sourceLanguage
        );
    }

    handleImageCancel(){
      this.props.cancelImage();
    }

    render() {

      const mediaType = this.props.images.sourceField != null ?
        this.props.images.sourceField.type : null;

      return (
				<div>

          <MediaSelectModal
            display={this.props.images.displayModal}
            field={this.props.images.sourceField}
            mediaType={mediaType}
            onImageSelected={this.handleImageSelected.bind(this)}
            onImageCancel={this.handleImageCancel.bind(this)}
          />

          <FormBar />

          <div className="container rightbar-page content">
            <FormSidebar />

            <div className="col-xs-9 page-content">
              <FormContent />
            </div>

          </div>

        </div>
      );
    }
}

const mapStateToProps = state => {
    return {
        app: state.app,
        images : state.images
    }
}

const mapDispatchToProps = dispatch => {
    return {
        initState: (payload) => {
            return dispatch(initState(payload));
        },
        updateImage: (field,media,fields,language) => {
            return dispatch(updateImage(field,media,fields,language));
        },
        cancelImage: () => {
            return dispatch(cancelImage());
        }
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(FormBuilder);
