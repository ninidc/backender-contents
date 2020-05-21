import React, {Component} from 'react';
import { render } from 'react-dom';
import Select from 'react-select';
import {connect} from 'react-redux';

import {
  //changeField
} from './actions/';

import Layout from './layout/Layout';

class FormSidebar extends Component {

  constructor(props) {
    super(props);
  }

  render() {

    var self = this;

    return (
      <div className="sidebar">
        <Layout
          layout={this.props.app.sidebar}
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

export default connect(mapStateToProps, mapDispatchToProps)(FormSidebar);
