import React, {Component} from 'react';
import { render } from 'react-dom';
import {connect} from 'react-redux';
import simpleNumberLocalizer from 'react-widgets-simple-number';
import { NumberPicker } from 'react-widgets'

import {
  changeField
} from './../../actions/';

import {
  TYPE_NUMBER
} from './../../constants/';

simpleNumberLocalizer();


class NumberField extends Component
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
      type : TYPE_NUMBER
    });

  }

  render() {

    const {field} = this.props;
    const errors = this.props.error ? 'has-error' : '';
    const value = this.props.app.fields[field.name] !== undefined &&
      this.props.app.fields[field.name].value ?
      this.props.app.fields[field.name].value : 0;

    return (

      <div className={"form-group bmd-form-group "+errors}>
          <label className="bmd-label-floating">
            {field.label}
          </label>
          <NumberPicker
            id={field.identifier}
            defaultValue={0}
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

export default connect(mapStateToProps, mapDispatchToProps)(NumberField);
