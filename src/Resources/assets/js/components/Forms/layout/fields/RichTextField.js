import React, {Component} from 'react';
import { render } from 'react-dom';
import {connect} from 'react-redux';
import ReactQuill from 'react-quill';
import 'react-quill/dist/quill.snow.css';

import {
  changeField
} from './../../actions/';

import {
  TYPE_RICHTEXT
} from './../../constants/';

class RichTextField extends Component
{
  constructor(props)
  {
    super(props);

  }

  handleOnChange(event)
  {
    const {field} = this.props;
    
    this.props.changeField({
      name : field.name,
      value : event,
      type : TYPE_RICHTEXT
    });

  }

  render() {
    const {field} = this.props;
    const errors = this.props.error ? 'has-error' : '';
    const value = this.props.app.fields[field.name] !== undefined &&
      this.props.app.fields[field.name].value ?
      this.props.app.fields[field.name].value : '';

    return (

      <div className={"form-group bmd-form-group "+errors}>
          <label className="bmd-label-floating">
            {field.label}
          </label>
          <ReactQuill
             id={field.identifier}
             name={field.name}
             placeholder={field.placeholder !== undefined ? field.placeholder : ''}
             value={value}
             onChange={this.handleOnChange.bind(this)}
           />
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
        }
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(RichTextField);
