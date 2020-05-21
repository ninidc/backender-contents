import React, {Component} from 'react';
import { render } from 'react-dom';
import Select from 'react-select';
import {connect} from 'react-redux';

import {
  //changeField
} from './../actions/';

import Col from './Col';

class Box extends Component {

  constructor(props) {
    super(props);
  }

  getPathToIndex(index) {
    const pathToIndex = this.props.pathToIndex.slice(0);
    pathToIndex.push(parseInt(index));
    return pathToIndex;
  }

  renderBox() {

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

    const hideTab = this.props.hideTab !== undefined && this.props.hideTab == true ? true : false;
    const {data} = this.props;

    return (
      <div className="field-item">
        <button  style={{display:(hideTab ? 'none' : 'block')}}  id={"heading"+data.identifier} className="btn btn-link" data-toggle="collapse" data-target={"#collapse"+data.identifier} aria-expanded="true" aria-controls={"collapse"+data.identifier}>
          <span className="field-name">
            {data.title}
          </span>
        </button>
        <div id={"collapse"+data.identifier} className="collapse in" aria-labelledby={"heading"+data.identifier} aria-expanded="true" aria-controls={"collapse"+data.identifier}>
          <div className="row box">
            {this.renderBox()}
          </div>
        </div>
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

export default connect(mapStateToProps, mapDispatchToProps)(Box);
