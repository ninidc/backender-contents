import React, {Component} from 'react';
import { render } from 'react-dom';
import {connect} from 'react-redux';

import {
  changeField
} from './../../actions/';

import {
  TYPE_TEXT
} from './../../constants/';

class TextField extends Component
{
  constructor(props)
  {
    super(props);

  }

  handleOnChange(event)
  {

    this.props.changeField({
      name : event.target.name,
      value : event.target.value,
      type : TYPE_TEXT
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
          <input
              id={field.identifier}
              type="text"
              className="form-control"
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

export default connect(mapStateToProps, mapDispatchToProps)(TextField);
