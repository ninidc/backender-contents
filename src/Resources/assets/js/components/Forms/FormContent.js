import React, {Component} from 'react';
import { render } from 'react-dom';
import Select from 'react-select';
import {connect} from 'react-redux';

import {
  //changeField
} from './actions/';

import Layout from './layout/Layout';

class FormContent extends Component {

  constructor(props) {
    super(props);

    ////console.log('PROPS ======>', props);

    this.handleChange = this.handleChange.bind(this);
  }

  handleChange(event) {

    var field = null;

    if(event.target.type == "text" || event.target.type == "richtext" || event.target.type == "font" || event.target.type == "select-one" || event.target.type == "number" || event.target.type == "color" ){
        field = {
            name : event.target.name,
            value : event.target.value
        };
    }
    else if(event.target.type == "checkbox"){
        field = {
            name : event.target.name,
            value : event.target.checked
        };
    }

    if(field != null) {
        this.props.changeField(field);
    }

  }

  render() {

    var self = this;

    console.log("FormContent => ",this.props.app)

    return (
      <div className="form-content">
        <Layout
          layout={this.props.app.body}
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
        /*
        changeField: (field) => {
            return dispatch(changeField(field));
        }
        */
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(FormContent);
