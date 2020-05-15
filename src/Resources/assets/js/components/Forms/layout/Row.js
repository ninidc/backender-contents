import React, {Component} from 'react';
import { render } from 'react-dom';
import Select from 'react-select';
import {connect} from 'react-redux';

import {
  //changeField
} from './../actions/';

import Col from './Col';

class Row extends Component {

  constructor(props) {
    super(props);
  }

  getPathToIndex(index) {
    const pathToIndex = this.props.pathToIndex.slice(0);
    pathToIndex.push(parseInt(index));
    return pathToIndex;
  }

  renderRow() {
      const {children} = this.props.data;

      if(children === undefined || children == null)
        return null;

      return children.map((item,index) => {
        if(item.type == "col"){
          return (
            <Col
              index={index}
              key={index}
              data={item}
              pathToIndex={this.getPathToIndex(index)}
              childrenLength={item.children.length}
            />
          )
        }
      });
  }

  render() {

    return (
      <div className="row">
        {this.renderRow()}
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

export default connect(mapStateToProps, mapDispatchToProps)(Row);
