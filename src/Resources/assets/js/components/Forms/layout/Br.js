import React, {Component} from 'react';
import { render } from 'react-dom';
import Select from 'react-select';
import {connect} from 'react-redux';


class Br extends Component {

  constructor(props) {
    super(props);
  }

  render() {

    return (
      <div className="separator">
        <br/>
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
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(Br);
