import React, {Component} from 'react';
import { render } from 'react-dom';
import {connect} from 'react-redux';

import {
  changeField,
  selectImage
} from './../../actions/';

class ImageField extends Component
{
  constructor(props)
  {
    super(props);

    this.onImageSelect = this.onImageSelect.bind(this);
    this.cancelImage = this.cancelImage.bind(this);

  }

  onImageSelect(event) {
    event.preventDefault();

    this.props.selectImage(this.props.field);
  }

  cancelImage(event) {
    event.preventDefault();

    this.props.changeField({
      name : this.props.field.identifier,
      value : null
    });
  }

  getImageFormat(value)
  {
      var format = null;

      if(IMAGES_FORMATS) {
          IMAGES_FORMATS.map(function(f){
              if(f.name == value) {
                  format = f;
              }
          });
      }

      return format;
  }

  render() {

    const {field} = this.props;
    const errors = this.props.error ? 'has-error' : '';
    const value = this.props.app.fields[field.name] !== undefined &&
      this.props.app.fields[field.name].value ?
      this.props.app.fields[field.name].value : '';
    var defined = this.props.app.fields[field.name] &&
      this.props.app.fields[field.name].value ? true : false;
    var format = field.format ? field.format : 'original';
    var url = value != null && value.urls ? value.urls.original : null;
    if(format && value && value.urls) {
        if(format) {
            url = value.urls[format];
        }
    }

    return (

      <div className={"form-group bmd-form-group image-field-container "+errors}>
        <div className="image-field">
           {url &&
           <div className="image" style={{backgroundImage:"url(/"+ url +")"}} ></div>
           }

           {(!defined || value.url == "" ) &&
             <div className="add-button">
               <a href="#" className="btn btn-default" onClick={this.onImageSelect}><i className="fa fa-plus-circle"></i>  {Lang.get('fields.select')}</a>
             </div>
           }
        </div>

         {defined && value.url != "" &&
           <div className="image-buttons">
             {/*<a href="" className="btn btn-link"><i className="fa fa-pencil-alt"></i> Editar</a>*/}
              <a href="" className="btn btn-link text-danger" onClick={this.cancelImage}><i className="fa fa-times"></i> {Lang.get('fields.delete')}</a>
           </div>
          }

          {format &&
              <p className="field-help"> <b>{format}</b> : {Lang.get('modals.sizes')} {format.width}x{format.height} (  {Lang.get('modals.ratio')} {format.ratio} )</p>
           }
      </div>
    );
  }

}


const mapStateToProps = state => {
    return {
        app: state.app
    }
}

const mapDispatchToProps = dispatch => {
    return {
        changeField: (field) => {
            return dispatch(changeField(field));
        },
        selectImage: (field) => {
            return dispatch(selectImage(field));
        }
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(ImageField);
