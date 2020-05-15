import React, {Component} from 'react';
import { render } from 'react-dom';
import {connect} from 'react-redux';

import {
  changeField
} from './../../actions/';

import {
  TYPE_FONT
} from './../../constants/';



class FontField extends Component
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
      type : TYPE_FONT
    });

  }

  renderOptions() {

    return (Object.keys(FONTS).map((item,i) => (
        <option value={item} key={i+1}>{item}</option>
      ))
    );
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
          <select className="form-control" id={field.identifier} name={field.name} value={value} onChange={this.handleOnChange.bind(this)} >
            <option value="" key={0}>---</option>
            {this.renderOptions()}
          </select>
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

export default connect(mapStateToProps, mapDispatchToProps)(FontField);
